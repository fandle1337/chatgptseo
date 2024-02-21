import {reactive, ref} from "vue";

export default function (fields = [], state = [])
{
    Object.keys(state).forEach(key => {
        fields.forEach(field => {
            if(field.code === key) {
                field.value = state[key]
            }
        })
    })

    return fields;
};