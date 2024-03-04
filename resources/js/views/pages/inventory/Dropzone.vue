<template>
  <div>
    <div
      ref="dropRef"
      class="dropzone custom-dropzone"
    />
    <div class="dropzone preview-container" />
  </div>
</template>

<script>
import { ref, onMounted, defineComponent } from 'vue'
import { Dropzone } from 'dropzone'
//import { useStore } from 'vuex'

export default defineComponent({
  name: 'Dropzone',
  props: ['paramName','paramUrl','id'],
  setup(props , { emit }) {
    //using vuex 
    //const store = useStore()
    //getting the div container
    const dropRef = ref(null)

    const customPreview = `
      <div class="d-flex flex-wrap dz-preview dz-processing dz-image-preview dz-complete" style="margin-top:'2px';">
        <div class="dz-image" style="margin-top:'2px';">
          <img data-dz-a\\Aq1 23thumbnail>
        </div>
        <div class="dz-details">
          <div class="dz-size"><span data-dz-size></span></div>
            <div class="dz-filename"><span data-dz-name></span></div>
          </div>
          <div class="dz-progress">
            <span class="dz-upload" data-dz-uploadprogress></span>
          </div>
          <div class="dz-error-message"><span data-dz-errormessage></span></div>
          <div class="dz-success-mark">
              <i class="bi bi-check-circle-fill" style="font-size: 2rem; color: green;"></i>
          </div>  
          <div class="dz-error-mark">
              <i class="bi bi-exclamation-circle-fill" style="font-size: 2rem; color: red;"></i> 
        </div>
      </div>
    `

    onMounted(() => { 
      if(dropRef.value !== null) {
        const dropzone =  new Dropzone(dropRef.value, {
          url: props.paramUrl,
          method: 'POST',
          headers: { Authorization: 'Bearer ' },
          paramName: props.paramName,   
          acceptedFiles: ".jpg,.png,.jpeg,.webp,.pdf,.doc,.docx,.zip",
          previewTemplate: customPreview,
          previewsContainer: dropRef.value.parentElement.querySelector('.preview-container'),          
         
        })

        dropzone.on('success', (file, response) => {     
          emit('upload-success', response)
        })
    
        if(dropRef.value.querySelector('.dz-default')) {
          dropRef.value.querySelector('.dz-default').innerHTML = `
            <div style="display: flex; justify-content: center;">
              <i class="bi bi-cloud-arrow-up-fill" style="font-size: 5rem;"></i>
            </div>
            <p style="text-align: center; margin: 0;"><strong>Drag and drop files to upload</strong></p>
          `
        }
      }
    })

    return {
      dropRef,
    }
  },
})
</script>

<style scoped>
.custom-dropzone {
  border-style: dashed;
  border-width: 3px;
  padding: 20px;
  color:rgb(114, 114, 114)
}
</style>
