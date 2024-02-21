import useFieldSelect from "./useFieldSelect";
import {computed, ref, toRef} from "vue";
import getLang from "../class/getLang";

export default function (value = null, options) {

    const optionValues = computed(() => {
        return options.value.entities ?? [];
    })

    return useFieldSelect(
        getLang("SKYWEB24_CHATGPTSEO_OPERATION_ENTITY"),
        "entities",
        value ?? optionValues.value[0]?.code,
        optionValues.value,
        getLang("SKYWEB24_CHATGPTSEO_OPERATION_ENTITY_TITLE")
    );
}
