<header class="d-print-none">
  <ul class="nav justify-content-center mt-2">
    <li class="nav-item ml-2 mr-2" v-for="(i, index) in menu" :index="index" :key="i.valor">
      <button 
        v-if="i.href === false"
        type="button" 
        class="btn btn-outline-dark rounded-circle" 
        :class="{active:actual == i.valor}"
        :title="i.titulo" 
        aria-label="Opción"
        @click.prevent="actual = i.valor"
      >
        <i :class="i.icono" aria-hidden="true"></i> 
      </button>
      <a 
        v-else
        :href="i.href"
        class="btn btn-outline-dark rounded-circle" 
        :title="i.titulo" 
        aria-label="Opción"
      >
        <i :class="i.icono" aria-hidden="true"></i> 
      </a>
    </li>
  </ul>
</header>