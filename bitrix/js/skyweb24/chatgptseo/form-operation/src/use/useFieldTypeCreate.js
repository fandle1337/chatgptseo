import useFieldListCreate from "./useFieldListCreate";

export default function ()
{
    return {
        code: "create",
        name: "create name",

        getFields()
        {
            return useFieldListCreate()
        }
    }
}