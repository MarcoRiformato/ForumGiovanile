<template>
    <div>
      <input type="file" @change="handleFileUpload" />
      <img v-if="imageUrl" :src="imageUrl" alt="Preview" />
    </div>
  </template>
  
  <script>
  import { ref, computed } from 'vue';
  
  export default {
    setup() {
      const selectedFile = ref(null);
  
      // This will be used as the src value in the img tag
      const imageUrl = computed(() => {
        // Return a data URL representing the selected file, if one is selected
        if (selectedFile.value) {
          return URL.createObjectURL(selectedFile.value);
        } else {
          return '';
        }
      });
  
      const handleFileUpload = (event) => {
        // Store the File object representing the selected file
        selectedFile.value = event.target.files[0];
      };
  
      return { imageUrl, handleFileUpload };
    }
  };
  </script>
  