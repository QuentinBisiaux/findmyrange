<template>
  <div class="container mx-auto my-8">
    <div class="flex justify-between mb-4">
      <div class="flex flex-col text-center border-2 p-4 rounded-2xl shadow"><span>Jouées</span><span>{{stats.sum.played}}</span></div>
      <div class="flex flex-col text-center border-2 p-4 rounded-2xl shadow"><span>Limped</span><span>{{stats.sum.limped}}</span></div>
      <div class="flex flex-col text-center border-2 p-4 rounded-2xl shadow"><span>Raised</span><span>{{stats.sum.raised}}</span></div>
      <div class="flex flex-col text-center border-2 p-4 rounded-2xl shadow"><span>Fold</span><span>{{stats.sum.folded}}</span></div>
      <div class="flex flex-col text-center border-2 p-4 rounded-2xl shadow"><span>Pourcentage Relancées</span><span>{{statsPercent}} %</span></div>
      <!--    Nombre de mains 3Bet {{stats.sum.3Bet}}<br/>
          Nombre de mains 4Bet {{stats.sum.4Bet}}<br/>-->
    </div>

    <div class="grid grid-rows-13 gap-2">
      <div class="grid grid-cols-13 gap-2">
        <div class="border drop-shadow-xl text-center py-3" v-for="hand in matrixOrder" :key="hand" :class="defineClass(hand)">
          <Box :hand="hand" :data="stats.hands[hand]" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Box from "@/components/matrice/Box.vue";
import matrixOrder from "@/data/matrixOrder.json";

export default {
  components: {Box},
  props: {
    stats: {
      type: Object,
      default: () => ({"hands":{"AA":{"played":5,"raised":3,"limped":0,"3Bet":1,"4Bet":0,"folded":0,"called":0},"AKs":{"played":3,"raised":1,"limped":0,"3Bet":1,"4Bet":0,"folded":0,"called":0},"AQs":{"played":5,"raised":5,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"AJs":{"played":2,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"ATs":{"played":8,"raised":7,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"A9s":{"played":3,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"A8s":{"played":6,"raised":3,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"A7s":{"played":3,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"A6s":{"played":1,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"A5s":{"played":3,"raised":3,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"A4s":{"played":3,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"A3s":{"played":2,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"A2s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"AK":{"played":10,"raised":4,"limped":1,"3Bet":3,"4Bet":0,"folded":0,"called":0},"KK":{"played":3,"raised":3,"limped":0,"3Bet":0,"4Bet":1,"folded":0,"called":0},"KQs":{"played":3,"raised":2,"limped":1,"3Bet":0,"4Bet":0,"folded":0,"called":0},"KJs":{"played":2,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"KTs":{"played":6,"raised":4,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"K9s":{"played":2,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"K8s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"K7s":{"played":4,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"K6s":{"played":5,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"K5s":{"played":8,"raised":1,"limped":1,"3Bet":0,"4Bet":0,"folded":4,"called":0},"K4s":{"played":7,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":5,"called":0},"K3s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"K2s":{"played":2,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"AQ":{"played":9,"raised":9,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"KQ":{"played":10,"raised":9,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"QQ":{"played":3,"raised":2,"limped":0,"3Bet":1,"4Bet":1,"folded":0,"called":0},"QJs":{"played":4,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"QTs":{"played":2,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"Q9s":{"played":1,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"Q8s":{"played":3,"raised":0,"limped":2,"3Bet":0,"4Bet":0,"folded":1,"called":0},"Q7s":{"played":5,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":4,"called":0},"Q6s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"Q5s":{"played":5,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"Q4s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"Q3s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"Q2s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"AJ":{"played":9,"raised":5,"limped":0,"3Bet":2,"4Bet":0,"folded":0,"called":0},"KJ":{"played":12,"raised":7,"limped":2,"3Bet":0,"4Bet":1,"folded":2,"called":0},"QJ":{"played":11,"raised":6,"limped":0,"3Bet":1,"4Bet":0,"folded":2,"called":0},"JJ":{"played":3,"raised":1,"limped":0,"3Bet":2,"4Bet":1,"folded":0,"called":0},"JTs":{"played":0,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"J9s":{"played":1,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"J8s":{"played":3,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"J7s":{"played":3,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"J6s":{"played":3,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":2,"called":0},"J5s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"J4s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"J3s":{"played":1,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"J2s":{"played":7,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":6,"called":0},"AT":{"played":8,"raised":5,"limped":1,"3Bet":0,"4Bet":0,"folded":1,"called":0},"KT":{"played":8,"raised":3,"limped":1,"3Bet":0,"4Bet":0,"folded":4,"called":0},"QT":{"played":13,"raised":4,"limped":2,"3Bet":0,"4Bet":0,"folded":6,"called":0},"JT":{"played":11,"raised":6,"limped":2,"3Bet":0,"4Bet":0,"folded":2,"called":0},"TT":{"played":2,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"T9s":{"played":3,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":2,"called":0},"T8s":{"played":5,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"T7s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"T6s":{"played":4,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"T5s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"T4s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"T3s":{"played":4,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"T2s":{"played":4,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"A9":{"played":7,"raised":6,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"K9":{"played":13,"raised":1,"limped":1,"3Bet":0,"4Bet":0,"folded":8,"called":0},"Q9":{"played":12,"raised":3,"limped":2,"3Bet":0,"4Bet":0,"folded":7,"called":0},"J9":{"played":13,"raised":4,"limped":2,"3Bet":0,"4Bet":0,"folded":6,"called":0},"T9":{"played":4,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"99":{"played":4,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"98s":{"played":4,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"97s":{"played":3,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"96s":{"played":5,"raised":1,"limped":1,"3Bet":0,"4Bet":0,"folded":2,"called":0},"95s":{"played":5,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"94s":{"played":1,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"93s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"92s":{"played":4,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"A8":{"played":12,"raised":7,"limped":0,"3Bet":1,"4Bet":0,"folded":2,"called":0},"K8":{"played":11,"raised":3,"limped":0,"3Bet":0,"4Bet":0,"folded":5,"called":0},"Q8":{"played":10,"raised":1,"limped":1,"3Bet":0,"4Bet":0,"folded":6,"called":0},"J8":{"played":11,"raised":1,"limped":1,"3Bet":0,"4Bet":0,"folded":4,"called":0},"T8":{"played":11,"raised":1,"limped":2,"3Bet":0,"4Bet":0,"folded":7,"called":0},"98":{"played":11,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":8,"called":0},"88":{"played":5,"raised":3,"limped":0,"3Bet":0,"4Bet":1,"folded":0,"called":0},"87s":{"played":3,"raised":0,"limped":2,"3Bet":0,"4Bet":0,"folded":2,"called":0},"86s":{"played":2,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":1,"called":0},"85s":{"played":4,"raised":1,"limped":1,"3Bet":0,"4Bet":0,"folded":2,"called":0},"84s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"83s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"82s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"A7":{"played":3,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"K7":{"played":9,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":4,"called":0},"Q7":{"played":12,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":12,"called":0},"J7":{"played":11,"raised":3,"limped":1,"3Bet":0,"4Bet":0,"folded":8,"called":0},"T7":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"97":{"played":12,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":12,"called":0},"87":{"played":9,"raised":0,"limped":2,"3Bet":0,"4Bet":0,"folded":5,"called":0},"77":{"played":4,"raised":1,"limped":0,"3Bet":1,"4Bet":0,"folded":0,"called":0},"76s":{"played":4,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"75s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"74s":{"played":4,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"73s":{"played":5,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"72s":{"played":6,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":5,"called":0},"A6":{"played":10,"raised":3,"limped":0,"3Bet":0,"4Bet":0,"folded":5,"called":0},"K6":{"played":11,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":9,"called":0},"Q6":{"played":8,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":7,"called":0},"J6":{"played":10,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":10,"called":0},"T6":{"played":19,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":16,"called":0},"96":{"played":9,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":7,"called":0},"86":{"played":8,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":6,"called":0},"76":{"played":9,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":7,"called":0},"66":{"played":11,"raised":9,"limped":0,"3Bet":1,"4Bet":0,"folded":0,"called":0},"65s":{"played":7,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":6,"called":0},"64s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"63s":{"played":5,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"62s":{"played":4,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"A5":{"played":6,"raised":3,"limped":1,"3Bet":0,"4Bet":0,"folded":2,"called":0},"K5":{"played":10,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":9,"called":0},"Q5":{"played":9,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":9,"called":0},"J5":{"played":10,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":9,"called":0},"T5":{"played":11,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":9,"called":0},"95":{"played":5,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"85":{"played":15,"raised":1,"limped":1,"3Bet":0,"4Bet":0,"folded":12,"called":0},"75":{"played":9,"raised":0,"limped":2,"3Bet":0,"4Bet":0,"folded":7,"called":0},"65":{"played":6,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":5,"called":0},"55":{"played":6,"raised":5,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"54s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"53s":{"played":4,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":3,"called":0},"52s":{"played":0,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"A4":{"played":8,"raised":2,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"K4":{"played":4,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"Q4":{"played":10,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":8,"called":0},"J4":{"played":5,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":5,"called":0},"T4":{"played":14,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":13,"called":0},"94":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"84":{"played":9,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":8,"called":0},"74":{"played":10,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":10,"called":0},"64":{"played":8,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":8,"called":0},"54":{"played":11,"raised":0,"limped":2,"3Bet":0,"4Bet":0,"folded":8,"called":0},"44":{"played":4,"raised":3,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"43s":{"played":2,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0},"42s":{"played":3,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"A3":{"played":12,"raised":3,"limped":1,"3Bet":0,"4Bet":0,"folded":5,"called":0},"K3":{"played":14,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":11,"called":0},"Q3":{"played":7,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":6,"called":0},"J3":{"played":12,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":12,"called":0},"T3":{"played":12,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":12,"called":0},"93":{"played":7,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":5,"called":0},"83":{"played":14,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":12,"called":0},"73":{"played":6,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":5,"called":0},"63":{"played":7,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":4,"called":0},"53":{"played":9,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":7,"called":0},"43":{"played":8,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":7,"called":0},"33":{"played":2,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":0,"called":0},"32s":{"played":1,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":1,"called":0},"A2":{"played":4,"raised":2,"limped":1,"3Bet":0,"4Bet":0,"folded":1,"called":0},"K2":{"played":5,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":5,"called":0},"Q2":{"played":8,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":7,"called":0},"J2":{"played":15,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":13,"called":0},"T2":{"played":11,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":9,"called":0},"92":{"played":12,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":11,"called":0},"82":{"played":9,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":8,"called":0},"72":{"played":10,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":8,"called":0},"62":{"played":6,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"52":{"played":7,"raised":1,"limped":0,"3Bet":0,"4Bet":0,"folded":3,"called":0},"42":{"played":12,"raised":0,"limped":0,"3Bet":0,"4Bet":0,"folded":9,"called":0},"32":{"played":8,"raised":0,"limped":1,"3Bet":0,"4Bet":0,"folded":5,"called":0},"22":{"played":5,"raised":4,"limped":0,"3Bet":0,"4Bet":0,"folded":2,"called":0}},"sum":{"played":1053,"raised":211,"limped":48,"3Bet":14,"4Bet":5,"folded":649,"called":0}}),
    },
    matrixOrder: {
      type: Array,
      default: () => matrixOrder
    },
    context: {
      type : Object,
      default: () => ({'handType' : 'raised', "players" : 'all', 'position': 'all'})
    }
  },
  computed: {
    statsPercent() {
      return (this.stats.sum.raised / this.stats.sum.played * 100).toFixed(4);
    },

    handPercentage() {
      return (hand) =>
          ((this.stats.hands[hand].raised) / this.stats.hands[hand].played * 100).toFixed(4);
    },
    defineClass() {
      return (hand) => {
        const parsedRaised = parseInt(this.stats.hands[hand].raised);
        const parsedPercent = parseFloat(this.handPercentage(hand));
        if (parsedRaised === 0) {
          return "bg-stone-800 text-white";
        } else if (parsedPercent <= 7.5) {
          return "bg-stone-700 text-white";
        } else if (parsedPercent <= 15) {
          return "bg-stone-600 text-white";
        } else if (parsedPercent <= 22.5) {
          return "bg-neutral-600 text-white";
        } else if (parsedPercent <= 30) {
          return "bg-neutral-500 text-white";
        } else if (parsedPercent <= 37.5) {
          return "bg-zinc-500 text-white";
        } else if (parsedPercent <= 45) {
          return "bg-zinc-400";
        } else if (parsedPercent <= 52.5) {
          return "bg-zinc-300";
        } else if (parsedPercent <= 60) {
          return "bg-lime-200";
        } else if (parsedPercent <= 67.5) {
          return "bg-lime-300";
        }  else if (parsedPercent <= 75) {
          return "bg-green-400";
        }  else if (parsedPercent <= 82.5) {
          return "bg-green-500";
        }  else if (parsedPercent <= 90) {
          return "bg-emerald-600 text-white";
        }   else if (parsedPercent <= 97.5) {
          return "bg-emerald-700 text-white";
        } else {
          return "bg-green-800 text-white";
        }
      }
    }
  }
};
</script>

<style>
/* You can add TailwindCSS classes here to style the matrix */
</style>
