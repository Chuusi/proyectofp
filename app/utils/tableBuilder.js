const weekDays = {
    monday: "Lunes",
    tuesday: "Martes",
    wednesday: "Miércoles",
    thursday: "Jueves",
    friday: "Viernes",
    saturday: "Sábado",
    sunday: "Domingo",
};

function buildTableForm(params) {
    const { tableData, allExercises, tableName, action, id = null } = params;

    const form = document.createElement("form");
    form.action = "userAction.php";
    form.method = "post";

    // Título
    const titleElement = document.createElement("h3");
    titleElement.textContent = tableName || `Tabla: ${new Date().getTime()}`;
    form.appendChild(titleElement);

    // Hidden input para el nombre
    const hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "tableName";
    hiddenInput.value = titleElement.textContent;
    form.appendChild(hiddenInput);

    // Hidden input para el ID
    if (id) {
        const idInput = document.createElement("input");
        idInput.type = "hidden";
        idInput.name = "id";
        idInput.value = id;
        form.appendChild(idInput);
    }

    // Recorrer días
    for (const day in tableData) {
        const exercises = tableData[day];
        const card = document.createElement("div");
        card.classList = "card p-3 mb-3 mt-3";

        const cardBody = document.createElement("div");
        cardBody.classList = "card-body";

        const title = document.createElement("h5");
        title.classList = "card-title";

        // Detectar si todos los ejercicios son del mismo grupo
        let sameGroup = true;
        let subtitle = "";
        const groupFirstExercise = exercises[0]?.group;

        for (let i = 0; i < exercises.length; i++) {
            if (exercises[i].group !== groupFirstExercise) {
                sameGroup = false;
                break;
            }
        }

        if (sameGroup) {
            const groupMap = {
                1: " - Pierna",
                2: " - Brazo",
                3: " - Core",
                4: " - Varios",
            };
            subtitle = groupMap[groupFirstExercise] || "";
        }

        title.textContent = weekDays[day] + subtitle;
        cardBody.appendChild(title);
        card.appendChild(cardBody);

        // Selects por ejercicio
        exercises.forEach((exercise, index) => {
            const exerciseName = exercise["name"] || exercise;

            const label = document.createElement("label");
            label.className = "form-label";
            label.textContent = `Ejercicio ${index + 1}`;

            const select = document.createElement("select");
            select.className = "form-select mb-2";
            select.name = `table[${day}][]`;

            allExercises.forEach((ex) => {
                const option = document.createElement("option");
                if (ex.name === exerciseName) {
                    option.selected = true;
                }
                option.value = JSON.stringify(ex);
                option.textContent =
                    ex.name + " - " + ex.reps + "x" + ex.series;
                select.appendChild(option);
            });

            cardBody.appendChild(label);
            cardBody.appendChild(select);
        });

        form.appendChild(card);
    }

    const submitButton = document.createElement("button");
    submitButton.type = "submit";
    submitButton.name = "action";
    submitButton.value = action;
    submitButton.className = "btn btn-success";
    submitButton.textContent =
        action === "saveTable" ? "Guardar tabla" : "Actualizar tabla";
    form.appendChild(submitButton);

    return form;
}
