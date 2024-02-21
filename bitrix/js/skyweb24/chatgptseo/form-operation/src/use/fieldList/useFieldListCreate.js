import {computed, reactive, ref} from "vue";
import useFieldEntity from "../useFieldEntity";
import useFieldFeature from "../useFieldFeature";
import useFieldOutput from "../useFieldOutput";
import useFieldLength from "../useFieldLength";

export default function (state = {}, options = {})
{

    const fieldEntity = reactive(useFieldEntity(state.entities, options));

    const fieldEntityFeatureList = computed(() => {
        return fieldEntity.options?.find(option => fieldEntity.value === option.code)?.feature_list ?? []
    })

    const fieldFieldFeature = reactive(useFieldFeature(state.feature, fieldEntityFeatureList));

    return [
        fieldEntity,
        reactive(useFieldOutput(state.output, options)),
        reactive(useFieldLength(state.input)),
        fieldFieldFeature
    ]
}