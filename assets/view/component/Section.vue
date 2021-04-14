<template>
    <div class="container-fluid">
      <div class="row" v-for="(section, index) in parentData">
        <div v-if="section.textAlign == 0">
          <div class="section-content-0 shadow" :class="{'bg-brown': index % 2 === 0, 'bg-blue': index % 2 !== 0 }">
            <h2>{{ section.title }}</h2>
            <p v-html="section.content">{{ section.content }}</p>
          </div>
          <img v-if="section.image != null" class="section-image-0 p-0 shadow"
               :src="'assets/uploads/section/'+ section.image" alt="section image">
        </div>
        <div v-else>
          <div class="section-content-1 shadow" :class="{'bg-brown': index % 2 === 0, 'bg-blue': index % 2 !== 0 }">
            <h2>{{ section.title }}</h2>
            <p v-html="section.content">{{ section.content }}</p>
          </div>
          <img v-if="section.image != null" class="img-fluid section-image-1 p-0 shadow"
               :src="'assets/uploads/section/'+ section.image" alt="section image">
        </div>
      </div>
    </div>
</template>

<script>
export default {
  name: "Section",
  props: ['parentData']

}
</script>

<style scoped>

</style>