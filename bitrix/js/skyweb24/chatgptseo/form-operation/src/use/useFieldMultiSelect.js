export default function (name, code, value = null, options = [], tooltip = '')
{
    return {
        type: "multiselect",
        code,
        name,
        value,
        options,
        tooltip,
    };
}