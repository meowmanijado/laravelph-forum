export default {
    methods: {
        data() {
            return {
                items: []
            }
        },
        add(item) {
            this.items.push(item);

            this.$emit('added');
        },

        removed(index) {
            this.items.splice(index, 1);
            this.$emit('removed');
            flash('Reply was deleted');
        }
    }
}