const selectedAll = document.querySelectorAll(".selected");

selectedAll.forEach((selected) => {
    const optionsContainer = selected.previousElementSibling;

    const optionsList = optionsContainer.querySelectorAll(".option");

    selected.addEventListener("click", () => {
        if (optionsContainer.classList.contains("active")) {
            optionsContainer.classList.remove("active");
        } else {
            let currentActive = document.querySelector(".options-container.active");

            if (currentActive) {
                currentActive.classList.remove("active");
            }

            optionsContainer.classList.add("active");
        }
    });

    optionsList.forEach((o) => {
        o.addEventListener("click", () => {
            if (o.classList.contains('gender-option')) {
                document.querySelector("#gender").value = o.querySelector("label").innerHTML;

            } else if (o.classList.contains('relation-option')) {
                document.querySelector("#relation").value = o.querySelector("label").innerHTML;

            } else if (o.classList.contains('status-option')) {
                document.querySelector("#status").value = o.querySelector("label").innerHTML;

            } else if (o.classList.contains('event-option')) {
                document.querySelector("#event").value = o.querySelector("label").innerHTML;

            } else if (o.classList.contains('beneficiar-option')) {
                document.querySelector("#beneficiar").value = o.querySelector("label").getAttribute('data-user-id');

            } else if (o.classList.contains('event-filter-option')) {
                document.querySelector("#event-filter").value = o.querySelector("label").getAttribute('data-event-id');

            } else if (o.classList.contains('attire-option')) {
                document.querySelector("#attire_name").value = o.querySelector("label").innerHTML;

            } else {
                document.querySelector("#topic-field").value = o.querySelector("label").innerHTML;

            }
            selected.innerHTML = o.querySelector("label").innerHTML;
            optionsContainer.classList.remove("active");
        });
    });
});