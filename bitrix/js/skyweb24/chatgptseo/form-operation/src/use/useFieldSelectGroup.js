export default function (name, code, value = null, options = [], tooltip = '')
{
    return {
        type: "select-group",
        code,
        name,
        value,
        options,
        tooltip
    };
}