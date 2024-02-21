import useFieldMultiSelect from "./useFieldMultiSelect";
import getLang from "../class/getLang";

export default function (value = [], options = [])
{
    return useFieldMultiSelect(
        getLang("SKYWEB24_CHATGPTSEO_OPERATION_FEATURE"),
        "feature",
        value,
        options,
        getLang('SKYWEB24_CHATGPTSEO_OPERATION_FEATURE_TITLE')
    )
}