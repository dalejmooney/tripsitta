<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-colorfield label="Line colour" :name="fieldName('color')" in-store="value"
></a17-colorfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
