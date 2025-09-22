<script setup lang="ts">
interface Props {
  label: string;
  digits: number[];
  previousDigits: number[];
  digitLimits: number[];
  showSeparator: boolean;
}

defineProps<Props>()
</script>

<template>
  <div :class="`${label}-wrapper`">
    <div :class="label">
      <div :class="`${label}-text flipTimer-label`">
        {{ label }}
      </div>
      <div
        v-for="(digit, index) in digits"
        :key="index"
        class="digit-set"
      >
        <div
          v-for="val in digitLimits[index]"
          :key="val"
          class="digit"
          :class="{
            active: val - 1 === digit,
            previous: val - 1 === previousDigits[index] && previousDigits[index] !== digit,
          }"
        >
          <div class="digit-top">
            <span class="digit-wrap">{{ val - 1 }}</span>
          </div>
          <div class="shadow-top" />
          <div class="digit-bottom">
            <span class="digit-wrap">{{ val - 1 }}</span>
          </div>
          <div class="shadow-bottom" />
        </div>
      </div>
    </div>
    <div
      v-if="showSeparator"
      class="seperator"
    >
      :
    </div>
  </div>
</template>

<style scoped>
.seperator {
  vertical-align: top;
  display: inline;
  color: #111111;
  font-size: 50px;
  margin: 6px 8px 0;
}

.seconds,
.minutes,
.hours,
.days,
.days-wrapper,
.hours-wrapper,
.minutes-wrapper,
.seconds-wrapper {
  height: 100%;
}

.days-wrapper,
.hours-wrapper,
.minutes-wrapper,
.seconds-wrapper {
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.seconds,
.minutes,
.hours,
.days {
  display: inline;
}

.flipTimer-label {
  font-size: 12px;
  line-height: 12px;
  text-transform: uppercase;
  font-weight: bold;
  width: 100%;
  text-align: center;
}

.digit-set {
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
  border: 1px solid #111111;
  width: 70px;
  height: 100%;
  display: inline-block;
  position: relative;
  margin: 0 1px;
  overflow: hidden;
}

.digit {
  position: absolute;
  height: 100%;
  color: #ffffff;
  width: 100%;
  transition: all 0.3s ease-in; /* Add a smooth transition for the flip */
}

.digit > div {
  position: absolute;
  left: 0;
  overflow: hidden;
  height: 50%;
  padding: 0 10px;
  width: 100%;
  box-sizing: border-box;
}

.digit > div.digit-top,
.digit > div.shadow-top {
  background-color: #333;
  border-bottom: 1px solid #333;
  top: 0;
  z-index: 0;
  border-radius: 10px 10px 0 0;
}

.digit > div.digit-top:before,
.digit > div.shadow-top:before {
  content: "";
  box-shadow: inset 0 10px 25px rgba(0, 0, 0, 0.4);
  height: 100%;
  width: 100%;
  position: absolute;
  left: 0;
  top: 0;
}

.digit > div.shadow-top {
  background: -webkit-gradient(
    linear,
    0% 0%,
    0% 100%,
    from(rgba(0, 0, 0, 0)),
    to(black)
  );
  width: 100%;
  opacity: 0;
  -webkit-transition: opacity 0.3s ease-in;
}

.digit > div.digit-bottom,
.digit > div.shadow-bottom {
  background-color: #333;
  bottom: 0;
  z-index: 0;
  border-radius: 0 0 10px 10px;
}

.digit > div.digit-bottom .digit-wrap,
.digit > div.shadow-bottom .digit-wrap {
  display: block;
  margin-top: -100%;
}

.digit > div.digit-bottom:before,
.digit > div.shadow-bottom:before {
  content: "";
  box-shadow: inset 0 10px 25px rgba(0, 0, 0, 0.3);
  border-radius: 0 0 10px 10px;
  height: 100%;
  width: 100%;
  position: absolute;
  left: 0;
  top: 0;
}

.digit > div.shadow-bottom {
  background: -webkit-gradient(
    linear,
    0% 0%,
    0% 100%,
    from(black),
    to(rgba(0, 0, 0, 0))
  );
  width: 100%;
  opacity: 0;
  -webkit-transition: opacity 0.3s ease-in;
}

.digit.previous .digit-top,
.digit.previous .shadow-top {
  opacity: 1;
  z-index: 2;
  transform-origin: 50% 100%;
  animation: flipTop 0.3s ease-in both;
}

.digit.previous .digit-bottom,
.digit.previous .shadow-bottom {
  z-index: 1;
  opacity: 1;
}

.digit.active .digit-top {
  z-index: 1;
}

.digit.active .digit-bottom {
  z-index: 2;
  transform-origin: 50% 0%;
  animation: flipBottom 0.3s 0.3s ease-out both;
}

@keyframes flipTop {
  0% { transform: perspective(400px) rotateX(0deg); }
  100% { transform: perspective(400px) rotateX(-90deg); }
}

@keyframes flipBottom {
  0% { transform: perspective(400px) rotateX(90deg); }
  100% { transform: perspective(400px) rotateX(0deg); }
}
</style>
