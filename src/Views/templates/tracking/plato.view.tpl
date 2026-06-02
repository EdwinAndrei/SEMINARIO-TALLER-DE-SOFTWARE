<section class="container-m row px-4 py-4">
    <h1>Detalle del Plato</h1>
</section>

<section class="container-m row px-4 py-4">

    <div class="col-12 col-m-8 offset-m-2 caps-form-card">

        <div class="row my-2">
            <label class="col-12 col-m-3">
                Código
            </label>

            <div class="col-12 col-m-9">
                {{platoId}}
            </div>
        </div>

        <div class="row my-2">
            <label class="col-12 col-m-3">
                Nombre
            </label>

            <div class="col-12 col-m-9">
                {{platoNombre}}
            </div>
        </div>

        <div class="row my-2">
            <label class="col-12 col-m-3">
                Stock
            </label>

            <div class="col-12 col-m-9">
                {{platoStock}}
            </div>
        </div>

        <div class="row my-4 flex-end">
            <button type="button"
                id="btnRegresar"
                class="caps-secondary-btn"
            >
                Regresar
            </button>
        </div>

    </div>

</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnRegresar")
        .addEventListener("click", () => {
            window.location.assign(
                "index.php?page=Tracking_Menu"
            );
        });
});
</script>