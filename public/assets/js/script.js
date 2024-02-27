document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("csvForm");
    const submitBtn = document.getElementById("submitBtn");

    submitBtn.addEventListener("click", async function () {
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: "POST",
                body: formData,
            });

            if (response.ok) {
                const result = await response.json(); // Suponiendo que el backend devuelve un JSON

                if (result.success) {
                    Swal.fire({
                        title: "Éxito",
                        text: "Registros insertados correctamente.",
                        icon: "success",
                    }).then(() => {
                        window.location.href = "/profile";
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Error al insertar la película. Datos no válidos.",
                        icon: "error",
                    });
                }
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Error al cargar el archivo CSV.",
                    icon: "error",
                });
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });
});
