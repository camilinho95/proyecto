<template>
   <div>
          {{ info }}
   </div>
</template>

<script>
export default {
   data () {
        return {
          info: null
        }
    },
     mounted () {
     axios.get('/sig').then(res =>{
        this.info = res.data.consult;

        console.log(this.info)
      })
    }
}
</script>