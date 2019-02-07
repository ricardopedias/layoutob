
@component('layout-ui::doc-admin', ['is_admin' => true])

    @include('layout-ui::admin.components.topmenu')

    @include('layout-ui::admin.components.sidemenu')

    <main>

        @include('layout-ui::admin.components.toppanel')

        @include('layout-ui::admin.components.pageloader')

        <section id="js-page-content" class="page-content p-3">

        </section>

        <aside>
            <!-- barra lateral -->
        </aside>

        @include('layout-ui::admin.components.bottompanel')

        <div class="clearfix"></div>

    </main>

    @include('layout-ui::admin.components.mainloader')

@endcomponent
