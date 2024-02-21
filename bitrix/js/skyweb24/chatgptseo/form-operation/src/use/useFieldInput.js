import useEntityPutList from "./useEntityPutList";
import getLang from "../class/getLang";
import useFieldSelectGroup from "./useFieldSelectGroup";

export default function (value = null, options)
{
    const optionValues = useEntityPutList(options);

    return useFieldSelectGroup(
        getLang("SKYWEB24_CHATGPTSEO_OPERATION_INPUT"),
        "input_fields",
        value ?? optionValues[0]?.option_list[0]?.code,
        optionValues,
        getLang('SKYWEB24_CHATGPTSEO_OPERATION_INPUT_TITLE')
    );
}