<template>
    <div class="w-full justify-center py-12 container mx-auto">
        <div class="bg-white rounded shadow overflow-hidden justify-center">
            <h1 class="mb-8 font-bold text-2xl m-10">
               Role Edit
            </h1>
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="absolute right-0 top-0 m-5">
                    <div class="flex items-center bg-green-500 border-l-4 border-green-700 py-2 px-3 shadow-md mb-2" v-show="showAlert">
                            <!-- icons -->
                        <div class="text-green-500 rounded-full bg-white mr-3">
                        <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                        </svg>
                        </div>
                        <!-- message -->
                        <div class="text-white max-w-xs ">
                            Updated Successfully!
                        </div>
                    </div>

                    <div class="flex items-center bg-red-500 border-l-4 border-red-700 py-2 px-3 shadow-md mb-2" v-for="error in errors">
                     <!-- icons -->
                        <div class="text-red-500 rounded-full bg-white mr-3">
                        <svg width="1.8em" height="1.8em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                        <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                        </svg>
                        </div>
                        <!-- message -->
                        <div class="text-white max-w-xs ">
                            {{error[0]}}
                        </div>
                    </div>

                </div>
                <form @submit.prevent="save(data)">
                    <div class="">
                        <div class="mb-4">

                           <br>

                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-4" id="exampleFormControlInput1" placeholder="Enter Title" v-model="data.title" required>

                            <textarea type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-4" id="exampleFormControlInput1" placeholder="Enter Description" v-model="data.body" required rows="4">
                             </textarea>
                        </div>


                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button @click.prevent="deletePost(data)" tabindex="-1" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"  >
                                Delete
                            </button>
                        </span>

                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button tabindex="-1" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"  >
                                Update
                            </button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto justify-left">
                            <inertia-link :href="route('posts.index')">
                                <button type="button" class="justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Back
                                </button>
                            </inertia-link>
                        </span>
                    </div>
                </form>
            </div>


        </div>

    </div>
</template>

<script>

    import AppLayout from '..//Layouts/AppLayout'
    import Welcome from '../Jetstream/Welcome'

export default {
    components: {
        AppLayout,
        Welcome,

        },
    props: ['data'],
        data() {
            return {
                showAlert: false,
                form: this.$inertia.form({
                    'title': '',
                    'body': '',
                }),
                 errors: {},

            }
        },

        created() {
            axios.get(this.route('posts-api.show',this.data.id))
                 .then((response) => {
                    this.role = response.data.data;
                    this.error = null;
                });
        },

    methods: {

        save(data) {

            axios.put(this.route('posts-api.update', data.id),data)
            .then(response => {
                this.showAlert=true,
                 this.errors = null;
                })
            .catch(e => {
                this.errors = e.response.data.errors,
                this.showAlert= false;
            });
        },

        deletePost(data){
            this.showAlert= false;
            if (confirm("Are you sure you to delete?")) {
                 axios.delete(this.route('posts-api.destroy', data.id))
                .then(response => this.showAlert=true);
                } else {
                alert("You pressed Cancel!");
            }

        },
    },


}
</script>
