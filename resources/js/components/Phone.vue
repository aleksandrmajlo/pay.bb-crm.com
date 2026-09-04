<template>
  <div class="flagWrapBooking">
    <input type="tel" class="form-control" id="phone_inp" />
    <input name="phone"  type="hidden" :value="phone" />
    <p v-show="phoneMess" class="mt-2  text-primary">
      {{ phoneMess }}
    </p>
</div>
</template>
<script>
import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import axios from "axios";
export default {
  name: "Phone",
  props: ["val","billiard_id"],
  data() {
    return {
      phone: this.val,
      iti: null,
      phoneMess: false,
      phoneInValid: true,
    };
  },
  mounted() {
    let self = this;
    let input = document.querySelector("#phone_inp");
    self.iti = intlTelInput(input, {
      initialCountry: "ua",
      onlyCountries: this.$LangFlag,
      showSelectedDialCode:1,
      separateDialCode: true,
      autoHideDialCode: false,
      nationalMode: false,
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.2.19/build/js/utils.js",
    });
    //readonly
    if(this.phone!=''){
        $("#phone_inp").prop("readonly",true)
        self.iti.setNumber(this.phone);
    }
    input.addEventListener("countrychange", function () {
      self.phone = self.iti.getNumber();
      if (self.iti.isValidNumber()) {
        self.phoneInValid = false;
        self.setCustomerAddForm();
      } else {
        self.phoneInValid = true;
        $("#userSubmit").prop("disabled", true);
      }
    });
    input.addEventListener("input", function () {
      self.phone = self.iti.getNumber();
      if (input.value.trim()) {
        if (self.iti.isValidNumber()) {
          // валидный номер
          console.log('valid' )
          self.phoneInValid = false;
          self.setCustomerAddForm();
        } else {
          console.log('phoneInValid ' )
          self.phoneInValid = true;
          $("#userSubmit").prop("disabled", true);
        }
      }
    });
  },
  methods: {
    setCustomerAddForm() {
      this.phoneMess = "Йде пошук клієнта за номером телефону ...";
      axios.post("/consumers_unique", {
        phone: this.phone ,
        billiard_id:this.billiard_id
      })
        .then((res) => {
          if (res.data.suc) {
               $("#userSubmit").prop("disabled", false);
               this.phoneMess = "Користувача з таким номером телефоном немає";
          } else {
            $("#userSubmit").prop("disabled",true);
            this.phoneMess = "Користувач із таким номером телефону існує";
          }
           setTimeout(() => {
              this.phoneMess = false;
            }, 2000);
        })
        .catch((err) => {

        });
    },
  },
};
</script>
<style>
.iti__flag {
  background-image: url("https://pay.bb-crm.com/img/flags.png") !important;
}

@media (min-resolution: 2x) {
  .iti__flag {background-image: url("https://pay.bb-crm.com/img/flags@2x.png") !important;
}
}
</style>

