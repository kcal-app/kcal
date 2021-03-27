<div x-data="searchView()" x-init="loadMore()">
    <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
        <nav class="md:w-1/4">
            <x-inputs.input name="search"
                            type="text"
                            class="w-full mb-4"
                            autocomplete="off"
                            autocapitalize="none"
                            inputmode="search"
                            placeholder="Search..."
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
        </nav>
        <section class="md:w-3/4">
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start">
                {{ $results }}
            </div>
            <svg x-show="searching" class="animate-spin h-24 w-24 mx-auto my-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-25" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div x-show="!searching && results.length === 0"
                 class="h-full w-full font-extrabold text-red-100">
                <div class="text-center text-6xl md:text-9xl">Nothing Found</div>
                <svg class="h-24 w-24 m-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
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
        </section>
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
                    searchTerm: null,
                    searching: false,
                    filterTags: [],
                    resetPagination() {
                        this.number = 1;
                        this.morePages = false;
                    },
                    loadMore() {
                        this.searching = true;
                        let url = `{{ $route }}?page[number]=${this.number}&page[size]=${this.size}`;
                        if (this.searchTerm) {
                            url += `&filter[search]=${this.searchTerm}`;
                        }
                        this.filterTags.every(tag => url += `&filter[tags.all][]=${tag}`)
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                this.results = [...this.results, ...data.data.map(result => result.attributes)];
                                if (this.number < data.meta.page['last-page']) {
                                    this.morePages = true;
                                    this.number++;
                                } else {
                                    this.morePages = false;
                                }
                                this.searching = false;
                            });
                    },
                    search(e) {
                        this.results = [];
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
                        this.results = [];
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
