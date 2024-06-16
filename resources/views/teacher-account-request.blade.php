<x-guest-layout>
  <div class=" w-full h-screen p-8">
    <div class="mt-5">
      <form action="/requestAccount" method="POST">
        @csrf
        <input type="hidden" name="role" value="professeur">
        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow sm:rounded-[15px]">
          <div class="w-full flex items-start ">
            <div x-data="{ photoName: null, photoPreview: null }" class="w-2/5 flex flex-col justify-start items-center gap-2">
              <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                x-on:change="
                    photoName = $refs.photo.files[0].name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        photoPreview = e.target.result;
                    };
                    reader.readAsDataURL($refs.photo.files[0]);
                    " />

              <!-- Current Profile Photo -->
              <div x-cloak x-show="! photoPreview">
                <img src="/images/profile-holder.jpg" alt=""
                  class="block rounded-full h-28 w-28 bg-cover bg-no-repeat bg-center">
              </div>

              <!-- New Profile Photo Preview -->
              <div x-show="photoPreview" style="display: none;">
                <span class="block rounded-full h-28 w-28 bg-cover bg-no-repeat bg-center"
                  x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                </span>
              </div>

              <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Ajouter Photo') }}
              </x-secondary-button>

              <x-input-error for="photo" class="mt-2" />
            </div>

            <div class="w-3/5 flex flex-col">
              <!-- Name -->
              <div class="h-24">
                <x-label for="name" value="Nom complet" />
                <x-input type="text" name="name" placeholder="nom complet"
                  class="text-center text-sm w-11/12 h-11" />
                <p class="text-red-500 text-sm p-2"></p>
              </div>

              <!-- Email -->
              <div class="h-24">
                <x-label for="email" value="Email" />
                <x-input type="email" type="email" name="email" placeholder="exemple@pro.uae.ac.ma"
                  class="text-center text-sm w-11/12 h-11" />
                <p class="text-red-500 text-sm p-2"></p>
              </div>

              <!-- CIN -->
              <div class="h-24">
                <x-label for="CIN" value="CIN" />
                <x-input type="text" name="CIN" placeholder="CIN" class="text-center text-sm w-11/12 h-11" />
                <p class="text-red-500 text-sm p-2"></p>
              </div>

              <!-- Diplome -->
              <div class="h-24">
                <x-label for="diploma" value="Diplôme" />
                <x-input name="diploma" class="text-center text-sm w-11/12 h-11" placeholder="diplôme" />
                <p class="text-red-500 text-sm p-2"></p>
              </div>

            </div>
          </div>
        </div>
        <div
          class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-6 shadow sm:rounded-bl-[15px] sm:rounded-br-[15px]">
          <x-button wire:loading.attr="disabled">
            {{ __('Enregistrer') }}
          </x-button>
        </div>
      </form>
    </div>
  </div>
  <x-loading />
</x-guest-layout>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const nameInput = form.querySelector('input[name="name"]');
    const emailInput = form.querySelector('input[name="email"]');
    const cinInput = form.querySelector('input[name="CIN"]');
    const diplomaInput = form.querySelector('input[name="diploma"]');
    // const photoInput = form.querySelector('input[type="file"]');
    const errorMessages = {
      name: 'Le nom complet est requis.',
      email: 'Un email valide est requis.',
      cin: 'Le CIN est requis.',
      diploma: 'Le diplôme est requis.',
      photo: 'Une photo est requise.'
    };

    function validateInput(input, errorMessage) {
      const errorContainer = input.nextElementSibling;
      if (input.value.trim() === '') {
        errorContainer.textContent = errorMessage;
        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
      } else {
        errorContainer.textContent = '';
        input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
      }
    }

    nameInput.addEventListener('input', () => validateInput(nameInput, errorMessages.name));
    emailInput.addEventListener('input', () => validateInput(emailInput, errorMessages.email));
    cinInput.addEventListener('input', () => validateInput(cinInput, errorMessages.cin));
    diplomaInput.addEventListener('input', () => validateInput(diplomaInput, errorMessages.diploma));
    // photoInput.addEventListener('change', () => validateInput(photoInput, errorMessages.photo));

    form.addEventListener('submit', function(event) {
      validateInput(nameInput, errorMessages.name);
      validateInput(emailInput, errorMessages.email);
      validateInput(cinInput, errorMessages.cin);
      validateInput(diplomaInput, errorMessages.diploma);
      //   validateInput(photoInput, errorMessages.photo);

      const invalidInputs = form.querySelectorAll('.border-red-500');
      if (invalidInputs.length > 0) {
        event.preventDefault();
      }
    });
  });
</script>
