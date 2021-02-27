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
                <summary>Tags</summary>
                @foreach($tags as $tag)
                    <a class="m-1 bg-gray-200 hover:bg-gray-300 rounded-full px-2 font-bold text-sm leading-loose cursor-pointer"
                       x-on:click="filterByTag($event);">{{ $tag->name }}</a>
                @endforeach
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
                    reset() {
                        this.number = 1;
                        this.searchTerm = null;
                        this.morePages = false;
                    },
                    loadMore() {
                        let url = `{{ $route }}?page[number]=${this.number}&page[size]=${this.size}`;
                        if (this.searchTerm) {
                            url += `&filter[search]=${this.searchTerm}`;
                        }
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
                        this.reset();
                        if (e.target.value !== '') {
                            this.searchTerm = e.target.value;
                            this.loadMore();
                        }
                        else {
                            this.loadMore();
                        }
                    },
                    filterByTag(e) {
                        console.log(e.target.text);
                    }
                }
            }
        </script>
    @endpush
@endonce
