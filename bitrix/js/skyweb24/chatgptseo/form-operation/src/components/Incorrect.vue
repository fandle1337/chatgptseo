<template>
    <div class="incorrect-builder-container">
        <div class="row h-100">
            <div class="col-3 h-100">
                <div class="incorrect-builder-menu">
                    <CascadeSelect
                            :pt="{
                                list: {
                                    class: 'option-list'
                                }
                            }"
                            :disabled="statusDisable"
                            :model-value="selectedPattern"
                            @group-change="onGroupChange"
                            @update:model-value="addCodeToTextarea"
                            :options="patterns"
                            option-label="name"
                            option-group-label="name"
                            :option-group-children="['option_list']"
                            :placeholder="getLang('SKYWEB24_CHATGPTSEO_INCORRECT_CHOOSE')"
                    >
                        <template #option="slotProps">
                            {{ slotProps.option.name }}
                        </template>
                    </CascadeSelect>
                    <Card class="mt-3">
                        <template #title>
                            {{ getLang('SKYWEB24_CHATGPTSEO_INCORRECT_TOOLTIP_TITLE') }}
                        </template>
                        <template #content>
                            <p>
                                {{ getLang('SKYWEB24_CHATGPTSEO_INCORRECT_TOOLTIP') }}
                            </p>
                        </template>
                    </Card>
                </div>
            </div>
            <div class="col-9 h-100">
                <Textarea
                        class="w-100 h-100"
                        autoResize
                        :model-value="text"
                        :disabled="disable"
                        @update:model-value="updateText"
                />
            </div>

        </div>
    </div>
</template>

<script>
import Textarea from 'primevue/textarea';
import {computed, ref, watchEffect} from "vue";
import {useStore} from 'vuex'
import Button from "primevue/button";
import CascadeSelect from "primevue/cascadeselect";
import getLang from "../class/getLang";
import ScrollPanel from "primevue/scrollpanel";
import Card from "primevue/card";

export default {
    methods: {getLang},
    components: {
        Textarea,
        Button,
        CascadeSelect,
        ScrollPanel,
        Card,
    },
    setup() {
        const store = useStore();
        const disable = computed(() => store.state.statusDisable)
        const text = ref("")
        const patterns = computed(() => {
            return store.state.options.incorrect
        })
        const updateText = function (event) {
            store.state.incorrectText = event
        }
        const selectedPattern = ref()
        const choosenGroup = ref(null)
        const onGroupChange = function (event) {
            choosenGroup.value = event.value.code
        }

        const addCodeToTextarea = function (event) {
            const prompt = '{' + choosenGroup.value + '.' + event.code + '}'
            store.state.incorrectText += prompt
            text.value += prompt
        }

        watchEffect(() => {
            text.value = store.state.incorrectText
        })

        const statusDisable = computed(() => store.state.statusDisable)
        return {
            patterns,
            text,
            disable,
            updateText,
            addCodeToTextarea,
            selectedPattern,
            onGroupChange,
            statusDisable,
        }
    }
}
</script>

<style>
.incorrect-builder-container {
    height: 250px;
}

.incorrect-builder-menu {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.incorrect-builder-menu-list {
    height: 100%;
    overflow-y: scroll;
    padding-right: 10px;
}

.option-list .option-list {
    max-height: 300px;
    overflow-y: auto;
}
.p-card .p-card-body .p-card-content {
    padding: 0;
}
.p-card .p-card-body {
    padding: 0.7rem !important;
}
.p-card {
    border: 1px solid #CDD3D9FF;
    transition: background-color 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s !important;
}

.p-card:hover {
    box-shadow: 0 0 5px 0 var(--border-color) !important;
    border-color: var(--border-color) !important;
    transition: background-color 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s !important;
}

.p-card .p-card-content {
    text-align: justify;
}

</style>
