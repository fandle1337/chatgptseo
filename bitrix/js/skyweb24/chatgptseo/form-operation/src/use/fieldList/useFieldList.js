import useFieldListCreate from "./useFieldListCreate";
import useFieldListTranslate from "./useFieldListTranslate";
import useFieldListRewrite from "./useFieldListRewrite";

export default function (type, options)
{
    let fieldList = [];

    if (type === 'create') {
        fieldList = useFieldListCreate({}, options);
    }

    if (type === 'rewrite') {
        fieldList = useFieldListRewrite({}, options);
    }

    if (type === 'translate') {
        fieldList = useFieldListTranslate({}, options);
    }
    return fieldList;
}