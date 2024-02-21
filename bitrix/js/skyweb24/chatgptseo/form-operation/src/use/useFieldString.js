export default function (name, code, value = null, tooltip = '')
{
    return {
        type: "string",
        code,
        name,
        value,
        tooltip,
    };
}