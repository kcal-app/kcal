<div x-data data-tags="{{ $defaultTags ?? '[]' }}">
    <div x-data="tagSelect()" x-init="init('parentEl')" @click.away="clearSearch()" @keydown.escape="clearSearch()">
        <div class="relative" @keydown.enter.prevent="addTag(searchTerm)">
            <x-inputs.input type="hidden"
                            name="tags"
                            value=""
                            x-model="tags"/>
            <x-inputs.label for="tag_picker" value="Tags"/>
            <div class="flex flex-row items-center">
                <x-inputs.input
                    type="text"
                    name="tag_picker"
                    class="mr-2"
                    x-model="searchTerm"
                    x-ref="searchTerm"
                    @input="search($event.target.value)"
                    placeholder="Enter some tags..." />
                <div x-show="open">
                    <div class="absolute z-40 left-0 mt-2">
                        <div class="py-1 text-sm bg-white rounded shadow-lg border border-gray-300">
                            <template x-for="result in results">
                                <a @click.prevent="addTag(result)"
                                   x-text="result"
                                   class="block py-1 px-5 cursor-pointer hover:bg-indigo-600 hover:text-white"></a>
                            </template>
                            <a @click.prevent="addTag(searchTerm)"
                               class="block py-1 px-5 cursor-pointer hover:bg-indigo-600 hover:text-white"
                               x-show="!results.includes(searchTerm)"
                               x-text="searchTerm"></a>
                        </div>
                    </div>
                </div>
                <template x-for="(tag, index) in tags">
                    <div class="bg-indigo-100 inline-flex items-center text-sm rounded mr-1">
                        <span class="ml-2 mr-1 leading-relaxed truncate max-w-xs" x-text="tag"></span>
                        <button @click.prevent="removeTag(index)" class="w-6 h-8 inline-block align-middle text-gray-500 hover:text-gray-600 focus:outline-none">
                            <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script type="text/javascript">
            function tagSelect() {
                return {
                    open: false,
                    searchTerm: '',
                    tags: [],
                    results: [],
                    init() {
                        this.tags = JSON.parse(this.$el.parentNode.getAttribute('data-tags'));
                    },
                    addTag(tag) {
                        tag = tag.trim()
                        if (tag !== "" && !this.hasTag(tag)) {
                            this.tags.push( tag )
                        }
                        this.clearSearch()
                        this.$refs.searchTerm.focus()
                    },
                    hasTag(tag) {
                        let foundTag = this.tags.find(e => {
                            return e.toLowerCase() === tag.toLowerCase()
                        })
                        return foundTag !== undefined
                    },
                    removeTag(index) {
                        this.tags.splice(index, 1)
                    },
                    search(q) {
                        if ( q.includes(",") ) {
                            q.split(",").forEach((val) => {
                                this.addTag(val)
                            }, this)
                        }
                        fetch('{{ route('api:v1:tags.index') }}?filter[name]=' + q)
                            .then(response => response.json())
                            .then(data => {
                                this.results = data.data.map(tag => tag.attributes.name);
                            });
                        this.toggleSearch();
                    },
                    clearSearch() {
                        this.searchTerm = ''
                        this.toggleSearch();
                    },
                    toggleSearch() {
                        this.open = this.searchTerm !== '';
                    }
                }
            }
        </script>
    @endpush
@endonce
