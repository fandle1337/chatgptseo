export default function (name, code, value = null, options = [], tooltip = '')
{
    return {
        type: "select",
        code,
        name,
        value,
        options,
        tooltip
    };
}