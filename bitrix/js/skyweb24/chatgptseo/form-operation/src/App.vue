<template>
    <div class="skyweb24-form-operation box p-3">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <Operation/>
                </div>
            </div>
        </div>
        <div class="row d-flex align-items-center mb-3">
            <div class="col-12 mt-3 d-flex flex-column">
                <div class="mb-2">
                    <h3>
                        <span :title="getLang('SKYWEB24_CHATGPTSEO_TITLE_STEP_3')">
                            {{ getLang("SKYWEB24_CHATGPTSEO_STEP_3") }}
                        </span>
                    </h3>
                </div>
                <Incorrect :text="incorrectText" v-model="incorrectText"/>
            </div>
        </div>
        <div style="padding-bottom: 10px; padding-top: 10px">
            <h3>
                <span :title="getLang('SKYWEB24_CHATGPTSEO_TITLE_STEP_4')">
                    {{ getLang("SKYWEB24_CHATGPTSEO_STEP_4") }}
                </span>
            </h3>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
<!--                    <div class="mb-3" v-if="query !== null">{{ getLang("SKYWEB24_CHATGPTSEO_QUERY_BUILD") }}</div>-->
                    <div class="text-area mb-3" v-if="query !== null" v-html="query"></div>
                    <div class="d-flex mb-3">
                        <Button
                                :label="getLang('SKYWEB24_CHATGPTSEO_GENERATE_ANSWER_GPT')"
                                :loading="requestLoadBuildQuery"
                                @click="onBuildQuery"
                                class="mr-3"
                        />
                    </div>
                    <div class="d-flex">
                        <Button
                                :label="getLang('SKYWEB24_CHATGPTSEO_FORM_SAVE')"
                                severity="success"
                                :loading="requestLoadSave"
                                @click="onFormSave"
                                class="mr-3 save"
                                :disabled="disable"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Operation from "./components/Operation.vue";
import Incorrect from "./components/Incorrect.vue";
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import Textarea from 'primevue/textarea';
import {computed, ref, toRef, watch} from "vue";
import {useStore} from 'vuex'
import getLang from "./class/getLang";

export default {
    components: {
        Operation,
        Incorrect,
        Button,
        Textarea,
        Dropdown
    },
    setup() {
        const store = useStore();

        const requestLoadSave = ref(false);
        const requestLoadBuildQuery = ref(false);

        const incorrectText = toRef(store.state, "incorrectText");
        const query = toRef(store.state, "query")
        const options = toRef(store.state, "options")
        const iblockId = computed(() => store.state.iblockId)
        const taskId = computed(() => store.state.taskId)
        const operationType = computed(() => store.getters.operationType);
        const elementType = computed(() => store.getters.elementType);
        const disable = computed(() => store.state.statusDisable)

        watch([taskId], async () => {
            await store.dispatch("updateTaskData", {
                task_id: store.state.taskId
            });
        })

        watch([iblockId], async () => {
            await store.dispatch("updateAppOptions", {
                iblock_id: store.state.iblockId,
                task_id: store.state.taskId
            })
        })

        let params = (new URL(document.location)).searchParams;

        document.addEventListener("iblockId:change", async (e) => {
            await store.commit("updateIblockId", e.detail)
            // await store.dispatch("updateTaskData", {
            //     task_id: store.state.taskId
            // })
        })

        store.commit("updateTaskId", params.get("id"));

        const onBuildQuery = function () {

            if (requestLoadBuildQuery.value) {
                return false;
            }

            requestLoadBuildQuery.value = true;

            store.dispatch("buildQuery", {
                task_id: store.state.taskId,
                iblock_id: store.state.iblockId,
                operation_type: operationType.value,
                element_type: elementType.value,
                operations: store.state.operations,
                incorrect_text: store.state.incorrectText,

            })

            requestLoadBuildQuery.value = false;
        }
        const onFormSave = async function () {

            if (requestLoadSave.value) {
                return false;
            }

            requestLoadSave.value = true;

            await store.dispatch("save", {
                task_id: store.state.taskId,
                iblock_id: store.state.iblockId,
                operation_type: operationType.value,
                element_type: elementType.value,
                operations: store.state.operations,
                incorrect_text: store.state.incorrectText,
            })

            requestLoadSave.value = false;
        }


        return {
            incorrectText,
            onBuildQuery,
            query,
            options,
            onFormSave,
            requestLoadSave,
            requestLoadBuildQuery,
            getLang,
            disable,
        }
    }
}
</script>
<style scoped>
.box {
    background: white;
}

.p-button.save:enabled:focus,
.p-button.save:enabled:hover {
    background: #22c55e;
    border-color: #22c55e;
}

.text-area {
    width: 100%;
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #87919c;
    padding: 5px;
    white-space: pre-line;
}
</style>
