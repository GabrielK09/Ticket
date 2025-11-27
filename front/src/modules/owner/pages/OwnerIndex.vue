<template>  
    <div class="">
        {{ LocalStorage.getItem('user') }}
        Home Page
        
    </div>
</template>

<script setup lang="ts">
    import { LocalStorage } from 'quasar';

</script>