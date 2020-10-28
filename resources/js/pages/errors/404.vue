<template>
<div class="container-fluid p-0">
  <div class="not-found-bg d-flex justify-content-center align-items-center">
    <div class="not-found-content text-center">
      <h1 class="mb-4 text-white font-weight-bold" style="font-size:5rem;">
        <!-- {{ $t('page_not_found') }} -->
        404
      </h1>
      <div class="links">
        <router-link :to="{ name: 'welcome' }">
          <Button type="primary">{{ $t('go_home') }}</Button>
        </router-link>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
