<template>
    <b-modal :id="id" size="lg" :title="field.config.names.singular">
        <b-row>
            <fj-field
                v-for="(field, key) in fields"
                :key="key"
                :field="field"
                :model-id="relation.id"
                :model="relation"
                @changed="$emit('update')"
            />
        </b-row>
        <template v-slot:modal-footer>
            <b-button
                class="fj-save-button"
                variant="primary"
                :disabled="!canSave"
                @click="Fjord.bus.$emit('save')"
            >
                {{ $t('fj.save') }}
            </b-button>
        </template>
    </b-modal>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: 'FieldRelationForm',
    props: {
        item: {
            type: Object,
            required: true
        },
        id: {
            required: true,
            type: String
        },
        field: {
            required: true,
            type: Object
        }
    },
    computed: {
        ...mapGetters(['canSave'])
    },
    data() {
        return {
            fields: [],
            relation: {}
        };
    },
    beforeMount() {
        this.relation = this.item;
        this.fields = this.setFieldsRoutePrefixId(
            Fjord.clone(this.field.form.fields),
            this.relation
        );
    },
    methods: {
        setFieldsRoutePrefixId(fields, relation) {
            for (let i in fields) {
                let field = fields[i];
                fields[i].route_prefix = field.route_prefix.replace(
                    '{id}',
                    relation.id
                );
                if (this.field.readonly) {
                    fields[i].readonly = true;
                }
            }
            return fields;
        }
    }
};
</script>
