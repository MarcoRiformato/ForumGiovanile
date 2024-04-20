<template>
<AppLayout title="LavorElba">

<p>Lavori in corso</p>

</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<style>
  @media (max-width: 800px) {
    #tr-1 {
      position: relative !important;
    }
    #td-1 {
      padding-top: 13px !important;
    }
    #td-2 {
      padding-left: 0.5em !important;
    }
  }
  @media (max-width: 600px) {
    #td-1 {
      padding: 3.5px !important;
    }
    #img-1 {
      width: 40px !important; height: 40px !important;
    }
    #td-2 {
      padding: 3.5px !important;
    }
    #td-3 {
      display: none !important; padding: 3.5px !important;
    }
    #td-4 {
      padding: 3.5px !important;
    }
    #td-5 {
      padding: 3.5px !important;
    }
  }
  @media (max-width: 1000px) {
    #td-1 {
      padding-top: 7px !important;
    }
    #td-5 {
      display: none !important;
    }
  }
  @media (max-width: 700px) {
    #td-3 {
      display: none !important;
    }
  }
  @media (max-width: 500px) {
    #td-5 {
      width: auto !important; display: none !important;
    }
  }
</style>