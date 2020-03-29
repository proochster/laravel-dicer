<template>
    <div class="rooms">
        <ul>
            <li v-for="room in rooms" :key="room.id">
                <a :href="room.hash">{{room.name}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        rooms: {
            type: Array,
            default: []
        }
    }
}
</script>