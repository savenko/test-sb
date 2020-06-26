<template>
    <div class="container example-component">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <el-form :inline="true" :model="form" class="demo-form-inline">
                            <el-form-item class="fill">
                                <el-input :disabled="isLoading" v-model="form.query" placeholder="Query"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button :loading="isLoading" type="primary" @click="onSubmit">
                                    Search
                                    <font-awesome-icon icon="search"/>
                                </el-button>
                            </el-form-item>
                        </el-form>
                        <div v-if="Object.keys(response).length>0" class="result">
                            <el-divider/>
                            <h2>Result <small>{{getTimeDuration}}</small></h2>
                            <pre :class="codeObj.class"><code :class="codeObj.class" v-html="codeObj.code"></code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import beautify from 'js-beautify';
import Prism from 'prismjs';
import 'prismjs/themes/prism.css';
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                query: ''
            },
            isLoading: false,
            response: {},
            timeStart: 0,
            timeEnd: 0,
        }
    },
    methods: {
        async onSubmit() {
            try {
                this.timeStart = new Date().getTime();
                this.isLoading = true;
                this.response = {};
                const {data} = await axios.get('/api/users', {params: this.form});
                this.response = data;
            } catch (e) {
                this.$alert('Oups. Something wrong. Please repeat your query', 'Error');
            } finally {
                this.isLoading = false;
                this.timeEnd = new Date().getTime();
            }
        },
        timeDistance (date1, date2) {
            let distance = Math.abs(date1 - date2);
            const hours = Math.floor(distance / 3600000);
            distance -= hours * 3600000;
            const minutes = Math.floor(distance / 60000);
            distance -= minutes * 60000;
            const seconds = Math.floor(distance / 1000);
            return `${('0' + minutes).slice(-2)} min ${('0' + seconds).slice(-2)} sec`;
        }
    },
    computed: {
        codeObj() {
            const data = beautify.js(JSON.stringify(this.response).trim(), {
                indent_size: 2,
                space_in_empty_paren: true,
                wrap_line_length: 50,
            });
            return {
                class: 'language-javascript',
                code: Prism.highlight(data, Prism.languages.javascript, 'javascript'),
            };
        },
        getTimeDuration(){
            return this.timeDistance(this.timeEnd, this.timeStart);
        }
    }
}
</script>

<style lang="scss">
.example-component {
    .fill {
        flex-grow: 1;
    }

    .el-form-item__content {
        width: 100%;
    }

    .el-form--inline {
        display: flex;
    }

    .result {
        min-height: 300px;
    }
}
</style>
