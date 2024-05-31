<section>

    <form class="statements_settings_right" id="categoryForm" method="GET" action="{{ url()->current() }}">
        <div class="dropdown">
            <div class="dropbtn">Категории</div>
            <div class="dropdown-content">

                <button value="" class="long_button">Все категории</button>
                @forelse ($categories as $category)
                    <button value="{{ $category->id }}" class="statements_categories_btn">{{ $category->name }}</button>

                @empty

                    <p>Категорий нет</p>
                @endforelse

            </div>
        </div>

    </form>

</section>
