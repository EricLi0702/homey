<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    middleware:'manager'
}
</script>