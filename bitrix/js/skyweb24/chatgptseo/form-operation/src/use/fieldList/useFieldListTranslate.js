import {computed, reactive, ref} from "vue";
import useFieldEntity from "../useFieldEntity";
import useFieldFeature from "../useFieldFeature";
import useFieldOutput from "../useFieldOutput";
import useFieldLength from "../useFieldLength";
import useFieldInput from "../useFieldInput";
import useFieldLanguage from "../useFieldLanguage";

export default function (state = {}, options = {})
{
    return [
        reactive(useFieldOutput(state.output, options)),
        reactive(useFieldInput(state.input, options)),
        reactive(useFieldLanguage(state.languages, options)),
    ]
}