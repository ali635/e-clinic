<template>
  <form class="bookService" @submit.prevent="handleBookService">
    <div class="flex justify-end mb-2">
      <button type="button" ref="closeModalBtn"
          class="cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
          data-modal-hide="book-modal">
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
          </svg>
          <span class="sr-only">Close modal</span>
      </button>
    </div>
    <div v-if="toaster.showToaster" class="fixed top-4 ltr:right-4 rtl:left-4">
      <div class="flex items-center p-4 mb-4 text-sm border rounded-lg w-[450px] max-w-[95%]" :class="{ 'text-green-800 border-green-300 bg-green-50' : toaster.status == 'success', 'text-red-800 border-red-300 bg-red-50' : toaster.status == 'error' }" role="alert">
        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
          <span class="font-medium" v-text="toaster.msg"></span>
        </div>
      </div>
    </div>

    <div class="slots_wrapper">
      <div class="mb-4">
        <VueDatePicker 
          v-model="selectedDate"
          :min-date="new Date()"
          inline
          auto-apply
          :disabled-dates="isDisabled"
          :enable-time-picker="false"
          :month-change-on-scroll="false"
        ></VueDatePicker>
      </div>
      
      <div class="flex flex-wrap gap-3 mb-4">
        <label v-for="(slot, index) in currentSelectedDateSlots" :key="index" class="slot_time" :class="(bookedTimeSlots && bookedTimeSlots.includes(`${selectedDate_formated_Date} ${slot.datetime}:00`)) ? 'choosen_slot_time' : ''">
          <input v-model="form.arrival_time" :disabled="bookedTimeSlots && bookedTimeSlots.includes(`${selectedDate_formated_Date} ${slot.datetime}:00`)" type="radio" class="option-input" name="timeSlots" :value="`${selectedDate_formated_Date} ${slot.datetime}:00`" />
          <span class="text-sm text-gray-700">{{ slot.datetime }}</span>
        </label>
      </div>
      <div class="mb-4">
        <div class="space-y-2">
          <label for="patient_description" class="block text-sm font-medium text-gray-700">
            {{ parsedDataObj.patient_description }}
          </label>
          <textarea v-model="form.patient_description" class="form-input" :placeholder="parsedDataObj.patient_description" name="patient_description" id="patient_description" rows="4"></textarea>
        </div>
      </div>
    </div>
    <div>
      <button type="submit"
          class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none transition-colors duration-200 cursor-pointer max-w-sm mx-auto" :class="{ 'btn-loading' : isLoading }">
          {{ parsedDataObj.book_now }}
      </button>
    </div>
  </form>
</template>

<script>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
  name: 'bookService',
  data() {
    return {
      parsedServiceDataObj: {},
      parsedDataObj: {},
      bookedTimeSlots: [],
      availableDays: [],
      service: {},
      timeSlots: {},
      selectedDate: null,
      selectedDate_formated_Date: null,
      currentSelectedDateSlots: [],
      form: {
        arrival_time: '',
        service_id: '',
        patient_id: '',
        patient_description: '',
      },
      toaster: {
        showToaster: false,
        msg: "",
        status: ""
      },
      _toasterTimeoutId: null,
      isLoading: false,
    }
  },
  components: { VueDatePicker },
  props: ["serviceDataObj", "dataObj"],
  methods: {
    generateTimeSlots(service) {
      const slots = {};
      const patientTimeMinute = service.patient_time_minute;
      
      service.schedules.forEach(schedule => {
          const scheduleSlots = [];
          
          // Parse start and end times
          const [startHour, startMinute] = schedule.start_time.split(':').map(Number);
          const [endHour, endMinute] = schedule.end_time.split(':').map(Number);
          
          // Convert to minutes for easier calculation
          let currentMinutes = startHour * 60 + startMinute;
          const endMinutes = endHour * 60 + endMinute;
          
          while (currentMinutes < endMinutes) {
              const slotStartHour = Math.floor(currentMinutes / 60);
              const slotStartMinute = currentMinutes % 60;
              
              const slotEndMinutes = currentMinutes + patientTimeMinute;
              const slotEndHour = Math.floor(slotEndMinutes / 60);
              const slotEndMinute = slotEndMinutes % 60;
              
              const formatTime = (hour, minute) => {
                  return `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
              };
              
              const slotStart = formatTime(slotStartHour, slotStartMinute);
              const slotEnd = formatTime(slotEndHour, slotEndMinute);
              
              scheduleSlots.push({
                  start: slotStart,
                  end: slotEnd,
                  display: `${slotStart} - ${slotEnd}`,
                  datetime: `${slotStart}`
              });
              
              currentMinutes += patientTimeMinute;
          }
          
          slots[schedule.day_of_week] = {
              day: schedule.day_of_week,
              schedule_id: schedule.id,
              slots: scheduleSlots
          };
      });
      
      return slots;
    },
    isDisabled(date){      
      const day = date.getDay()
      return !this.availableDays.includes(day)
    },
    async handleBookService() {
      // Check if required fields are filled (service_id, selectedDate_formated_Date, and arrival_time)
      if (!this.form.service_id || !this.selectedDate_formated_Date || !this.form.arrival_time) {
        console.log("this.form");
        console.log(this.form);
        console.log(this.selectedDate_formated_Date);
        
        this.handleToaster(this.parsedDataObj?.missing_data, 'error');
        return;
      }
      const that = this;
      this.isLoading = true;
      try {
        fetch('/api/v1/patient/create/visit/web', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
          body: JSON.stringify(this.form),
        })
          .then(response => response.json())
          .then(res => {
            if(res.status){
              this.form.arrival_time = '';
              this.form.patient_description = '';
              this.selectedDate = null;
              this.selectedDate_formated_Date = null;

              that.handleToaster(res.message, 'success');
              // that.$refs?.closeModalBtn?.click();
            }else {
              that.handleToaster(res.message, 'error');
            }
          })
          .catch(() => {            
            that.handleToaster(this.parsedDataObj?.something_wrong, 'error');
          })
          .finally(() => {
            this.isLoading = false;
          })
        
        // if (!response.ok) {
        //   throw new Error('Failed to book service');
        // }
      } catch (error) {
        that.handleToaster(this.parsedDataObj?.something_wrong, 'error');
      }
    },
    handleToaster(msg, status = 'success'){
      if(!msg) return;
      // Clear any existing timeout to prevent multiple overlapping timers
      if (this._toasterTimeoutId) {
        clearTimeout(this._toasterTimeoutId);
        this._toasterTimeoutId = null;
      }

      // Show the toaster
      this.toaster = {
        showToaster: true,
        msg: msg,
        status: status
      };      

      // Set up a new timeout to auto-hide the toaster after 3 seconds
      this._toasterTimeoutId = setTimeout(() => {
        // Only hide if the user hasn't clicked to dismiss
        if (this.toaster && this.toaster.showToaster) {
          this.toaster.showToaster = false;
        }
        this._toasterTimeoutId = null;
      }, 5000);
    },
  },
  mounted(){
    this.parsedServiceDataObj = this.serviceDataObj ? JSON.parse(this.serviceDataObj) : {};
    this.parsedDataObj = this.dataObj ? JSON.parse(this.dataObj) : {};
    this.bookedTimeSlots = this.parsedServiceDataObj?.booked_times || [];
    this.service = this.parsedServiceDataObj?.service || {};
    this.form.service_id = this.service?.id || '';
    this.form.patient_id = this.parsedDataObj?.patient_id || '';
    this.timeSlots = this.generateTimeSlots(this.service);
    const schedules = this.parsedServiceDataObj?.service?.schedules || [];
    this.availableDays = schedules.map(schedule => schedule.day_of_week);
    
    console.log("this.parsedServiceDataObj");
    console.log(this.parsedServiceDataObj);
  },
  watch: {
    selectedDate(newVal){
      const jsDay = newVal.getDay()
      const dayNumber = jsDay === 0 ? 7 : jsDay;
      const day = String(newVal.getDate()).padStart(2, '0')
      const month = String(newVal.getMonth() + 1).padStart(2, '0') // months start at 0
      const year = newVal.getFullYear()

      this.selectedDate_formated_Date = `${year}-${month}-${day}`;
      this.currentSelectedDateSlots = this.timeSlots ? (this.timeSlots[dayNumber]?.slots || []) : [];
      this.form.arrival_time = '';
    }
  }
}
</script>

<style lang="scss">
.slots_wrapper {
  .dp__today {
    border: 0 !important;
  }

  .dp__main {
    & > div:last-child {
      width: 100% !important;
      .dp__cell_inner {
        margin-inline: auto !important;
      }
    }
  }

  .slot_day {
    border: 1px solid #1f2937; 
    padding: 1rem; /* p-4 */
    border-radius: 0.5rem; /* rounded-lg */
    margin-bottom: 1rem; /* mb-4 */
  }
  .slot_time {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem; /* gap-2 */
    border: 1px solid #e5e7eb; /* gray-200 */
    border-radius: 0.375rem; /* rounded-md */
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem; /* px-4 py-2 */
    min-height: 30px; /* min-h-[30px] */
    cursor: pointer;
    transition: all 0.2s;
    &:not(.choosen_slot_time):hover {
      background-color: #f3f4f6; /* hover:bg-gray-100 */
    }
    &.choosen_slot_time {
      opacity: 0.6;
      cursor: not-allowed;
    }
  }
}

body[dir="rtl"] {
  .dp__month_year_wrap {
    flex-direction: row-reverse !important;
  }
}
</style>
