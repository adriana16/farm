<template>
    <i @click="deleteBox" class="fas fa-trash" style="font-size: 18px; color: red; cursor:pointer;"></i>
</template>

<script>
    export default {
        props: ['boxId'],
        name: 'delete-box',

        mounted: function () {
            console.log('Component mounted.')
        },

        methods: {
            deleteBox: function () {
                var url = Routing.generate('box_remove', {'id': this.boxId});

                axios
                    .delete(url)
                    .then(function(response) {
                        window.location.href = Routing.generate('box_index');
                    })
                    .catch(function(errors) {
                        if (errors.response.status === 401) {
                            console.log('error');
                        }
                    })
                ;
            }
        }
    }
</script>
