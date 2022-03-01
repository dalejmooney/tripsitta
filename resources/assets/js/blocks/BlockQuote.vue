<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Quote" :name="fieldName('quote')" type="textarea" :required="true" :maxlength="250" :rows="3" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
