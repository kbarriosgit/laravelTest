<!-- resources/views/persona/fechas.blade.php -->
<div class="bg-white p-4 rounded-lg shadow-lg">
    <h3 class="text-lg font-semibold">Desglose de Fechas</h3>
    <div class="p-4 md:p-5">
        <div id="fechas-grid" class="grid grid-cols-6 gap-1">
            @foreach ($fechas as $fecha)
                <span style="color:black;">{{ $fecha }},</span>
            @endforeach
        </div>
    </div>
    <button id="close-fechas-modal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Cerrar</button>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('close-fechas-modal').addEventListener('click', function() {
            console.log("closefechas");

            document.getElementById('fechas-modal-information').classList.add('hidden');
        });

        document.getElementById('fechas-modal-information').addEventListener('click', function(event) {
            if (event.target === this) {
                this.classList.add('hidden');
            }
        });
    });
</script>
