import {computed, toRef} from "vue";
export default function (options)
{
    const optionValues = computed(() => {
        return options.value.input_fields ?? [];
    })

    return optionValues.value;
}