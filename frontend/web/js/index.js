const autoCompletejs = new autoComplete({
    data: {
        src: async () => {
            const query = document.querySelector("#autoComplete").value;
            const source = await fetch(`/location/${query}`);
            const data = await source.json();
            return data;
        },
        key: ["title"],
        cache: false
    },
    selector: "#autoComplete",
    threshold: 3,
    debounce: 300,
    searchEngine: "strict",
    highlight: false,
    maxResults: 5,
    resultsList: {
        render: true,
        position: "afterend",
        element: "ul",
    },
    resultItem: {
        content: (data, source) => {
            source.innerHTML = data.match;
        },
        element: "li",
    },
    onSelection: feedback => {
        const selection = feedback.selection.value.title;
        document.querySelector("#autoComplete").value = selection;
        const coordinates = feedback.selection.value.coordinates.split(' ');
        document.querySelector("#longitude").value = coordinates[0];
        document.querySelector("#latitude").value = coordinates[1];
    }
});