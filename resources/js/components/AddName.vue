<template>
    <div class="name">
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add name</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input
                                type="text"
                                class="form-control"
                                v-model="name"
                                @keydown.enter="sendName"
                                placeholder="Your name"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="sendName"
                        >
                            Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: ""
        };
    },
    methods: {
        sendName() {
            if (this.name == "") {
                return;
            }

            this.$emit("send", this.name);
            this.name = "";
        }
    }
};
</script>
