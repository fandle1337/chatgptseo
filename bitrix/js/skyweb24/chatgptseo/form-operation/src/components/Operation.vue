<template>
    <div class="d-flex mb-3">
        <div style="width: 100%;" class="d-flex mr-3">
            <div class="mr-3 w-100">
                <div class="mb-2">
                    <span v-tooltip.top="getLang('SKYWEB24_CHATGPTSEO_OPERATION_TYPE_TITLE')">
                        {{ getLang('SKYWEB24_CHATGPTSEO_OPERATION_TYPE') }}
                    </span>
                </div>
                <Dropdown
                    style="width: 100%;"
                    optionLabel="name"
                    optionValue="code"
                    :options="typeList"
                    :modelValue="type"
                    @change="onChangeType($event.value)"
                    :disabled="disable"
                />
            </div>
            <div class="w-100">
                <div class="mb-2">
                    <span v-tooltip.top="getLang('SKYWEB24_CHATGPTSEO_TYPE_ELEMENT_TITLE')">
                        {{ getLang('SKYWEB24_CHATGPTSEO_TYPE_ELEMENT') }}
                    </span>
                </div>
                <Dropdown
                    style="width: 100%;"
                    optionLabel="name"
                    optionValue="code"
                    :options="elementTypeList"
                    :modelValue="elementType"
                    @change="onUpdateElementType($event.value)"
                    :disabled="disable"
                />
            </div>
        </div>
        <div class="d-flex flex-shrink-0">
            <Button
                class="mt-auto"
                :label="getLang('SKYWEB24_CHATGPTSEO_ADD_OPERATION')"
                :disabled="disable"
                @click="onAddOperation"
            />
        </div>
    </div>
    <div class="d-flex flex-column table mb-3">
        <div class="d-flex table-row-header align-items-center">
            <div class="w-100 table-column" v-for="operation of operationTableHead">
                <b v-tooltip.top="operation.tooltip">{{ operation.name }}</b>
            </div>
            <div style="width: 80px" class="flex-shrink-0 table-column"></div>
        </div>
        <div class="d-flex table-row" v-for="(fields, i) of operationListSelected">
            <div class="w-100 table-column" v-for="field of fields" :key="field.code">
                <InputText
                    style="width: 100%; height: 100%"
                    v-if="field.type === 'string'"
                    v-model="operations[i][field.code]"
                    :disabled="disable"
                />
                <Dropdown
                    style="width: 100%; height: 100%"
                    v-else-if="field.type === 'select'"
                    optionLabel="name"
                    optionValue="code"
                    :options="field.options"
                    v-model="operations[i][field.code]"
                    :disabled="disable"
                />
                <Dropdown
                    style="width: 100%; height: 100%"
                    v-else-if="field.type === 'select-group'"
                    optionLabel="name"
                    optionValue="code"
                    optionGroupLabel="name"
                    optionGroupChildren="option_list"
                    :options="field.options"
                    v-model="operations[i][field.code]"
                    :disabled="disable"
                />
                <MultiSelect
                    style="width: 100%; height: 100%"
                    v-else-if="field.type === 'multiselect'  && field.options.length > 0"
                    optionLabel="name"
                    optionValue="code"
                    :options="field.options"
                    v-model="operations[i][field.code]"
                    :disabled="disable"
                />
            </div>
            <div style="width: 80px" class="flex-shrink-0 justify-content-center table-column">
                <Button
                    label="x"
                    severity="danger"
                    @click="onRemoveOperation(i)"
                    :disabled="disable"
                />
            </div>
        </div>
    </div>
</template>
<script>
import {computed, watch} from "vue";
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import MultiSelect from 'primevue/multiselect';
import Button from 'primevue/button';
import {useStore} from 'vuex'
import getLang from "../class/getLang";
import useFieldList from "../use/fieldList/useFieldList";

export default {
    components: {
        InputText,
        Button,
        MultiSelect,
        Dropdown
    },

    setup(props, {emit}) {


        const store = useStore();

        const operationType = computed(() => store.getters.operationType);
        const elementType = computed(() => store.getters.elementType);
        const operations = computed(() => store.state.operations)
        const options = computed(() => store.state.options);
        const iblockId = computed(() => store.state.iblockId)
        const elementTypeList = computed(() => options.value?.element_types ?? [])
        const typeList = computed(() => options.value?.types);
        const type = computed(() => store.getters.operationType)
        const disable = computed(() => store.state.statusDisable)

        const onUpdateElementType = function (value) {
            store.commit("updateElementType", value)
        }

        const operationListSelected = computed(() => {
            return operations.value.map(operation => {
                return useFieldList(operationType.value, options)
            })
        });

        const operationTableHead = computed(() => {
            return useFieldList(operationType.value, options).map(e => {
                return {
                    name: e.name,
                    tooltip: e.tooltip,
                }
            })
        })

        const onAddOperation = (e) => {

            const fieldList = useFieldList(operationType.value, options);

            if (fieldList.length === 0) {
                throw new Error("Field not found")
            }

            let object = {};

            for (let field of useFieldList(operationType.value, options)) {
                object[field.code] = field.value;
            }

            store.commit("pushOperation", object)
        }
        const onChangeType = function (value) {
            store.commit("updateOperationType", value)
            store.commit("updateOperations", []);

            onAddOperation();
        }

        watch([options], async () => {
            if (operations.value.length === 0) {
                onChangeType(type.value)
            }
        })

        const onRemoveOperation = function (e) {
            operations.value.length <= 1
                ? alert(getLang("SKYWEB24_CHATGPTSEO_OPERATION_FEW_ELEMENTS"))
                : operations.value.splice(e, 1);
        }


        return {
            typeList,
            type,
            operationListSelected,
            onRemoveOperation,
            operationTableHead,
            onAddOperation,
            onChangeType,
            elementTypeList,
            elementType,
            operations,
            onUpdateElementType,
            getLang,
            disable
        }
    }
}
</script>
<style scoped>
.table {
    border: 1px solid #ced4da;
}

.table-row-header {
    height: 40px;
    border-bottom: 1px solid #ced4da;
}

.table-row {
    height: 60px;
}

.table-row + .table-row {
    border-top: 1px solid #ced4da;
}

.table-column {
    padding: 7px;
    overflow: hidden;
    display: flex;
    align-items: center;
}

.table-column + .table-column {
    border-left: 1px solid #ced4da;
}
</style>