<template>
    <input 
        type="submit" 
        class="btn btn-danger d-block w-100 mb-2" 
        value="Eliminar ×"
        @click="eliminarReceta">
</template>

<script>
export default {
    props : ['recetaId'],
    methods : {
        eliminarReceta(){
            Swal.fire({
                title: '¿Deseas eliminar esta receta?',
                text: "Una vez eliminada, no se puede recuperar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const params = {
                        id: this.recetaId
                    }
                    //Enviar una petición al servidor
                    axios.post(`/recetas/${this.recetaId}`, {params, _method: 'delete'})
                        .then(respuesta => {
                            Swal.fire(
                                'Receta eliminada',
                                'Se eliminó la receta',
                                'success'
                            )
                            //Eliminar la receta del DOM
                            this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode)
                        })
                        .catch(error => {
                            console.log(error)
                        })
                    // Swal.fire(
                    //     'Receta eliminada',
                    //     'Se eliminó la receta',
                    //     'success'
                    // )
                }
            })
        }
    }
}
</script>
