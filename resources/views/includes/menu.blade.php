<div class="list-group">
      @if (auth()->check())
        <a href="/perfil" class="list-group-item list-group-item-action">Mis datos</a>
            @if (auth()->user()->is_admin)
               <a href="/usuarios" class="list-group-item list-group-item-action">Administración Usuarios</a>
            @endif      
            <a href="/sig" class="list-group-item list-group-item-action">SIG</a>
      @endif      
</div>