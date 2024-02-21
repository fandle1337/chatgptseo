import useFieldListTranslate from "./useFieldListTranslate";

export default function ()
{

    return {
        code: "translate",
        name: "translate type name",

        getFields()
        {
            return useFieldListTranslate()
        }
    }
}