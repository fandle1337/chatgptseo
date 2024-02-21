import useFieldString from "./useFieldString";
import getLang from "../class/getLang";

export default function (value = null)
{
    return useFieldString(
        getLang("SKYWEB24_CHATGPTSEO_OPERATION_LENGTH"),
        "length",
        value ?? 250,
        getLang('SKYWEB24_CHATGPTSEO_OPERATION_LENGTH_TITLE')
    );
}