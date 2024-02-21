import useFieldSelect from "./useFieldSelect";
import getLang from "../class/getLang";
import {computed} from "vue";

export default function (value = null, options)
{
    const optionValues = computed(() => {
        return options.value.languages ?? [];
    })

    return useFieldSelect(
        getLang("SKYWEB24_CHATGPTSEO_OPERATION_LANGUAGE"),
        "languages",
        value ?? optionValues.value[0]?.code,
        optionValues,
        getLang('SKYWEB24_CHATGPTSEO_OPERATION_LANGUAGE_TITLE')
    );
}