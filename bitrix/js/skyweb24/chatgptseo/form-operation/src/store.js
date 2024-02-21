import {createStore} from "vuex";

export default createStore({
    state() {
        return {
            options: {},
            operations: [],
            operationType: null,
            incorrectText: null,
            elementType: null,
            query: null,
            taskId: null,
            iblockId: null,
            statusDisable: false,
        }
    },
    mutations: {
        updateAppOption(state, value) {
            state.options = value;
        },
        updateOperations(state, value) {
            state.operations = value;
        },
        pushOperation(state, value) {
            state.operations.push(value);
        },
        updateOperationType(state, value) {
            state.operationType = value;
        },
        updateIncorrectText(state, value) {
            state.incorrectText = value;
        },
        updateElementType(state, value) {
            state.elementType = value;
        },
        updateQuery(state, value) {
            state.query = value;
        },
        updateIblockId(state, value) {
            state.iblockId = value;
        },
        updateTaskId(state, value) {
            state.taskId = value;
        },
        updateStatusDisable(state, value) {
            state.statusDisable = value
        }
    },
    actions: {
        async fetchAppOptions({state, commit, dispatch}, payload) {
            return new Promise((resolve => {
                BX.ajax.runAction("skyweb24:chatgptseo.api.ControllerFormQueryBuilder.getOptionList", {
                    data: payload
                })
                    .then(e => {
                        resolve(e.data)
                    })
            }))
        },
        async fetchTaskStore({state, commit, dispatch}, payload) {
            return new Promise((resolve => {
                BX.ajax.runAction("skyweb24:chatgptseo.api.ControllerFormQueryBuilder.store", {
                    data: payload
                }).then(e => resolve(e.data))
            }))
        },
        async requestBuildQuery({state, commit, dispatch}, payload) {
            return new Promise((resolve => {
                BX.ajax.runAction("skyweb24:chatgptseo.api.ControllerFormQueryBuilder.buildQuery", {
                    data: payload
                }).then(e => resolve(e.data))
            }))
        },
        async updateAppOptions({state, commit, dispatch}, payload) {
            commit("updateAppOption", await dispatch("fetchAppOptions", payload))
        },
        async updateTaskData({state, commit, dispatch}, payload) {
            const data = await dispatch("fetchTaskStore", payload);

            commit("updateOperations", data.operations ?? [])
            commit("updateOperationType", data.operation_type)
            commit("updateIncorrectText", data.incorrect_text)
            commit("updateElementType", data.element_type)
            commit("updateIblockId", data.iblockId)
            commit("updateStatusDisable", data.status_disable)
        },
        async buildQuery({state, commit, dispatch}, payload) {
            commit("updateQuery", await dispatch("requestBuildQuery", payload));
        },
        async save(context, payload) {
            return new Promise((resolve => {
                BX.ajax.runAction("skyweb24:chatgptseo.api.ControllerFormQueryBuilder.save", {
                    data: payload
                }).then(e => resolve(e.data))
            }))
        },
    },
    getters: {
        elementType(state) {
            if (state.elementType) {
                return state.elementType;
            }

            if (state.options?.element_types) {
                return state.options?.element_types[0]?.code
            }
        },

        operationType(state) {
            if (state.operationType) {
                return state.operationType;
            }

            if (state.options?.types) {
                return state.options?.types[0]?.code
            }
        }
    }
})