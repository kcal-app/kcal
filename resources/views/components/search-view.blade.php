<div x-data="searchView()" x-init="loadMore()">
    <x-inputs.input type="text"
                    name="search"
                    placeholder="Search..."
                    autocomplete="off"
                    class="w-full mb-4"
                    @input.debounce.400ms="search($event)" />
    <div class="grid grid-cols-3 gap-4">
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
                        this.results = [];
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
                                this.results = [...this.results, ...data.data.map(result => result.attributes)];
                                if (this.number < data.meta.page['last-page']) {
                                    this.morePages = true;
                                } else {
                                    this.number++;
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
                    }
                }
            }
        </script>
    @endpush
@endonce
