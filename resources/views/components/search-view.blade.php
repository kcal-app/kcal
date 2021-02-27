<div x-data="searchView()" x-init="loadMore()">
    <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
        <div class="md:w-1/4">
            <x-inputs.input type="text"
                            name="search"
                            placeholder="Search..."
                            autocomplete="off"
                            class="w-full mb-4"
                            @input.debounce.400ms="search($event)" />
            <details open>
                <summary>Filters</summary>
                <div class="my-2 pl-2 p-1 border-blue-200 border-b-2 font-bold">Tags</div>
                <div class="flex flex-wrap">
                    @foreach($tags as $tag)
                        <a class="m-1 bg-gray-200 hover:bg-gray-300 rounded-full px-2 leading-loose cursor-pointer"
                           x-on:click="updateFilters($event);">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </details>
        </div>
        <div class="md:w-3/4">
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start">
                {{ $results }}
            </div>
            <x-inputs.button
                class="text-xl mt-4"
                color="blue"
                type="button"
                x-show="morePages"
                x-cloak
                @click.prevent="loadMore()">
                Load more
            </x-inputs.button>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script type="text/javascript">
            let searchView = () => {
                return {
                    results: [],
                    number: 1,
                    size: 12,
                    morePages: false,
                    searchTerm: '{{ $defaultSearch ?? null }}',
                    filterTags: [],
                    resetPagination() {
                        this.number = 1;
                        this.morePages = false;
                    },
                    loadMore() {
                        let url = `{{ $route }}?page[number]=${this.number}&page[size]=${this.size}`;
                        if (this.searchTerm) {
                            url += `&filter[search]=${this.searchTerm}`;
                        }
                        this.filterTags.every(tag => url += `&filter[tags.all][]=${tag}`)
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                this.results = [];
                                this.results = [...this.results, ...data.data.map(result => result.attributes)];
                                if (this.number < data.meta.page['last-page']) {
                                    this.morePages = true;
                                    this.number++;
                                } else {
                                    this.morePages = false;
                                }
                            });
                    },
                    search(e) {
                        this.resetPagination();
                        if (e.target.value !== '') {
                            this.searchTerm = e.target.value;
                        }
                        else {
                            this.searchTerm = null;
                        }
                        this.loadMore();
                    },
                    updateFilters(e) {
                        this.resetPagination();
                        const newTag = e.target.text;
                        if (this.filterTags.includes(newTag)) {
                            this.filterTags = this.filterTags.filter(tag => tag !== newTag)
                            e.target.classList.remove('bg-gray-600', 'text-white');
                        }
                        else {
                            this.filterTags.push(newTag)
                            e.target.classList.add('bg-gray-600', 'text-white');
                        }
                        this.loadMore();
                    }
                }
            }
        </script>
    @endpush
@endonce
