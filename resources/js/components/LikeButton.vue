<template>
    <div>
        <span class="like-btn" @click="likeReceta" :class="{'like-active' : isActive}"></span>
        <p>{{cantidadLikes}} Les gustó esta receta</p>
    </div>
</template>

<script>
//https://codepen.io/AlHakem/pen/yZGWxJ
//Twitter heart and medium clap button
export default {
    props : ['recetaId', 'like', 'likes'],
    data : function(){
        return {
            isActive : this.like,
            totalLikes : this.likes,
        }
    },
    methods : {
        likeReceta(){
            axios.post('/recetas/'+this.recetaId)
                .then(respuesta => {
                    if(respuesta.data.attached.length > 0){
                        this.$data.totalLikes++;
                    }else{
                        this.$data.totalLikes--;
                    }
                    this.isActive = !this.isActive
                })
                .catch(error => {
                    if(error.response.status === 401){
                        window.location = '/register';
                    }
                });
        }
    },
    computed : {
        cantidadLikes : function(){
            return this.totalLikes
        }
    }
}
</script>
