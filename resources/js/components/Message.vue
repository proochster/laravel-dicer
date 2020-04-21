<template>
    <div class="message rounded px-3 py-1 mb-2 mx-3">
        <span class="message_name">{{m.name}}</span>
        <span v-if="m.text" class="message_text">{{m.text}}</span>
        <span v-if="m.diceType" class="message_dice" :data-d="m.diceType">D{{m.diceType}}</span>
        <span v-if="m.diceRoll" class="message_roll">{{m.diceRoll}}</span>
    </div>
</template>

<script>
export default {
    props:{
        m:{
            type: Object,
            required: true
        }
    }
}
</script>