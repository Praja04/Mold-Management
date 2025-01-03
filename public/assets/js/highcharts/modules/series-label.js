/*
 Highcharts JS v10.3.3 (2023-01-20)

 (c) 2009-2021 Torstein Honsi

 License: www.highcharts.com/license
*/
(function (a) {
  "object" === typeof module && module.exports
    ? ((a["default"] = a), (module.exports = a))
    : "function" === typeof define && define.amd
      ? define("highcharts/modules/series-label", ["highcharts"], function (u) {
          a(u);
          a.Highcharts = u;
          return a;
        })
      : a("undefined" !== typeof Highcharts ? Highcharts : void 0);
})(function (a) {
  function u(a, d, B, k) {
    a.hasOwnProperty(d) ||
      ((a[d] = k.apply(null, B)),
      "function" === typeof CustomEvent &&
        window.dispatchEvent(
          new CustomEvent("HighchartsModuleLoaded", {
            detail: { path: d, module: a[d] },
          }),
        ));
  }
  a = a ? a._modules : {};
  u(a, "Extensions/SeriesLabel/SeriesLabelDefaults.js", [], function () {
    return {
      enabled: !0,
      connectorAllowed: !1,
      connectorNeighbourDistance: 24,
      format: void 0,
      formatter: void 0,
      minFontSize: null,
      maxFontSize: null,
      onArea: null,
      style: { fontWeight: "bold" },
      useHTML: !1,
      boxesToAvoid: [],
    };
  });
  u(a, "Extensions/SeriesLabel/SeriesLabelUtilities.js", [], function () {
    function a(a, k, d, y, m, t) {
      a = (t - k) * (d - a) - (y - k) * (m - a);
      return 0 < a ? !0 : !(0 > a);
    }
    function d(B, k, d, y, m, t, z, A) {
      return (
        a(B, k, m, t, z, A) !== a(d, y, m, t, z, A) &&
        a(B, k, d, y, m, t) !== a(B, k, d, y, z, A)
      );
    }
    return {
      boxIntersectLine: function (a, k, u, y, m, t, z, A) {
        return (
          d(a, k, a + u, k, m, t, z, A) ||
          d(a + u, k, a + u, k + y, m, t, z, A) ||
          d(a, k + y, a + u, k + y, m, t, z, A) ||
          d(a, k, a, k + y, m, t, z, A)
        );
      },
      intersectRect: function (a, k) {
        return !(
          k.left > a.right ||
          k.right < a.left ||
          k.top > a.bottom ||
          k.bottom < a.top
        );
      },
    };
  });
  u(
    a,
    "Extensions/SeriesLabel/SeriesLabel.js",
    [
      a["Core/Animation/AnimationUtilities.js"],
      a["Core/Chart/Chart.js"],
      a["Core/FormatUtilities.js"],
      a["Core/Defaults.js"],
      a["Extensions/SeriesLabel/SeriesLabelDefaults.js"],
      a["Extensions/SeriesLabel/SeriesLabelUtilities.js"],
      a["Core/Utilities.js"],
    ],
    function (a, d, u, k, O, y, m) {
      function t(c, a, f, b, g) {
        var h = c.chart,
          H = c.options.label || {},
          C = D(H.onArea, !!c.area),
          l = C || H.connectorAllowed,
          e = h.boxesToAvoid,
          F = Number.MAX_VALUE,
          k = Number.MAX_VALUE,
          q,
          d,
          w;
        for (w = 0; e && w < e.length; w += 1)
          if (
            P(e[w], {
              left: a,
              right: a + b.width,
              top: f,
              bottom: f + b.height,
            })
          )
            return !1;
        for (w = 0; w < h.series.length; w += 1) {
          var n = h.series[w];
          e = n.interpolatedPoints && Q([], n.interpolatedPoints, !0);
          if (n.visible && e) {
            var p = h.plotHeight / 10;
            for (d = h.plotTop; d <= h.plotTop + h.plotHeight; d += p)
              e.unshift({ chartX: h.plotLeft, chartY: d }),
                e.push({ chartX: h.plotLeft + h.plotWidth, chartY: d });
            for (p = 1; p < e.length; p += 1) {
              if (
                e[p].chartX >= a - 16 &&
                e[p - 1].chartX <= a + b.width + 16
              ) {
                if (
                  K(
                    a,
                    f,
                    b.width,
                    b.height,
                    e[p - 1].chartX,
                    e[p - 1].chartY,
                    e[p].chartX,
                    e[p].chartY,
                  )
                )
                  return !1;
                c === n &&
                  !q &&
                  g &&
                  (q = K(
                    a - 16,
                    f - 16,
                    b.width + 32,
                    b.height + 32,
                    e[p - 1].chartX,
                    e[p - 1].chartY,
                    e[p].chartX,
                    e[p].chartY,
                  ));
              }
              if ((l || q) && (c !== n || C)) {
                d = a + b.width / 2 - e[p].chartX;
                var x = f + b.height / 2 - e[p].chartY;
                F = Math.min(F, d * d + x * x);
              }
            }
            if (
              !C &&
              l &&
              c === n &&
              ((g && !q) || F < Math.pow(H.connectorNeighbourDistance || 1, 2))
            ) {
              for (p = 1; p < e.length; p += 1)
                if (
                  ((q = Math.min(
                    Math.pow(a + b.width / 2 - e[p].chartX, 2) +
                      Math.pow(f + b.height / 2 - e[p].chartY, 2),
                    Math.pow(a - e[p].chartX, 2) + Math.pow(f - e[p].chartY, 2),
                    Math.pow(a + b.width - e[p].chartX, 2) +
                      Math.pow(f - e[p].chartY, 2),
                    Math.pow(a + b.width - e[p].chartX, 2) +
                      Math.pow(f + b.height - e[p].chartY, 2),
                    Math.pow(a - e[p].chartX, 2) +
                      Math.pow(f + b.height - e[p].chartY, 2),
                  )),
                  q < k)
                ) {
                  k = q;
                  var m = e[p];
                }
              q = !0;
            }
          }
        }
        return !g || q
          ? { x: a, y: f, weight: F - (m ? k : 0), connectorPoint: m }
          : !1;
      }
      function z(a) {
        a.boxesToAvoid = [];
        var C = a.labelSeries || [],
          c = a.boxesToAvoid;
        a.series.forEach(function (b) {
          return (b.points || []).forEach(function (a) {
            return (a.dataLabels || []).forEach(function (a) {
              var g = a.getBBox(),
                h = a.translateX + (b.xAxis ? b.xAxis.pos : b.chart.plotLeft);
              a = a.translateY + (b.yAxis ? b.yAxis.pos : b.chart.plotTop);
              c.push({
                left: h,
                top: a,
                right: h + g.width,
                bottom: a + g.height,
              });
            });
          });
        });
        C.forEach(function (b) {
          var a = b.options.label || {};
          b.interpolatedPoints = A(b);
          c.push.apply(c, a.boxesToAvoid || []);
        });
        a.series.forEach(function (b) {
          function g(b, a, c) {
            var e = Math.max(d, D(y, -Infinity)),
              h = Math.min(d + k, D(z, Infinity));
            return b > e && b <= h - c.width && a >= q && a <= q + m - c.height;
          }
          var h = b.options.label;
          if (h && (b.xAxis || b.yAxis)) {
            var c = "highcharts-color-" + D(b.colorIndex, "none"),
              C = !b.labelBySeries,
              l = h.minFontSize,
              e = h.maxFontSize,
              f = a.inverted,
              d = f ? b.yAxis.pos : b.xAxis.pos,
              q = f ? b.xAxis.pos : b.yAxis.pos,
              k = a.inverted ? b.yAxis.len : b.xAxis.len,
              m = a.inverted ? b.xAxis.len : b.yAxis.len,
              n = b.interpolatedPoints,
              p = D(h.onArea, !!b.area),
              x = [],
              u = b.xData || [],
              r,
              v = b.labelBySeries;
            if (p && !f) {
              f = [b.xAxis.toPixels(u[0]), b.xAxis.toPixels(u[u.length - 1])];
              var y = Math.min.apply(Math, f);
              var z = Math.max.apply(Math, f);
            }
            if (b.visible && !b.boosted && n) {
              v ||
                ((v = b.name),
                "string" === typeof h.format
                  ? (v = R(h.format, b, a))
                  : h.formatter && (v = h.formatter.call(b)),
                (b.labelBySeries = v =
                  a.renderer
                    .label(v, 0, 0, "connector", 0, 0, h.useHTML)
                    .addClass(
                      "highcharts-series-label highcharts-series-label-" +
                        b.index +
                        " " +
                        (b.options.className || "") +
                        " " +
                        c,
                    )),
                a.renderer.styledMode ||
                  ((c = "string" === typeof b.color ? b.color : "#666666"),
                  v.css(
                    L(
                      { color: p ? a.renderer.getContrast(c) : c },
                      h.style || {},
                    ),
                  ),
                  v.attr({
                    opacity: a.renderer.forExport ? 1 : 0,
                    stroke: b.color,
                    "stroke-width": 1,
                  })),
                l &&
                  e &&
                  v.css({
                    fontSize:
                      l +
                      ((b.sum || 0) / (b.chart.labelSeriesMaxSum || 0)) *
                        (e - l) +
                      "px",
                  }),
                v.attr({ padding: 0, zIndex: 3 }).add());
              l = v.getBBox();
              l.width = Math.round(l.width);
              for (f = n.length - 1; 0 < f; --f)
                p
                  ? ((e = n[f].chartX - l.width / 2),
                    (c = (n[f].chartCenterY || 0) - l.height / 2),
                    g(e, c, l) && (r = t(b, e, c, l)))
                  : ((e = n[f].chartX + 3),
                    (c = n[f].chartY - l.height - 3),
                    g(e, c, l) && (r = t(b, e, c, l, !0)),
                    r && x.push(r),
                    (e = n[f].chartX + 3),
                    (c = n[f].chartY + 3),
                    g(e, c, l) && (r = t(b, e, c, l, !0)),
                    r && x.push(r),
                    (e = n[f].chartX - l.width - 3),
                    (c = n[f].chartY + 3),
                    g(e, c, l) && (r = t(b, e, c, l, !0)),
                    r && x.push(r),
                    (e = n[f].chartX - l.width - 3),
                    (c = n[f].chartY - l.height - 3),
                    g(e, c, l) && (r = t(b, e, c, l, !0))),
                  r && x.push(r);
              if (h.connectorAllowed && !x.length && !p)
                for (e = d + k - l.width; e >= d; e -= 16)
                  for (c = q; c < q + m - l.height; c += 16)
                    (r = t(b, e, c, l, !0)) && x.push(r);
              if (x.length) {
                if (
                  (x.sort(function (b, a) {
                    return a.weight - b.weight;
                  }),
                  (r = x[0]),
                  (a.boxesToAvoid || []).push({
                    left: r.x,
                    right: r.x + l.width,
                    top: r.y,
                    bottom: r.y + l.height,
                  }),
                  (n = Math.sqrt(
                    Math.pow(Math.abs(r.x - (v.x || 0)), 2) +
                      Math.pow(Math.abs(r.y - (v.y || 0)), 2),
                  )) &&
                    b.labelBySeries &&
                    ((x = {
                      opacity: a.renderer.forExport ? 1 : 0,
                      x: r.x,
                      y: r.y,
                    }),
                    (h = { opacity: 1 }),
                    10 >= n && ((h = { x: x.x, y: x.y }), (x = {})),
                    (n = void 0),
                    C && ((n = I(b.options.animation)), (n.duration *= 0.2)),
                    b.labelBySeries
                      .attr(
                        L(x, {
                          anchorX:
                            r.connectorPoint &&
                            (r.connectorPoint.plotX || 0) + d,
                          anchorY:
                            r.connectorPoint &&
                            (r.connectorPoint.plotY || 0) + q,
                        }),
                      )
                      .animate(h, n),
                    (b.options.kdNow = !0),
                    b.buildKDTree(),
                    (b = b.searchPoint({ chartX: r.x, chartY: r.y }, !0))))
                )
                  v.closest = [b, r.x - (b.plotX || 0), r.y - (b.plotY || 0)];
              } else v && (b.labelBySeries = v.destroy());
            } else v && (b.labelBySeries = v.destroy());
          }
        });
        S(a, "afterDrawSeriesLabels");
      }
      function A(a) {
        function c(a) {
          var e =
            Math.round((a.plotX || 0) / 8) +
            "," +
            Math.round((a.plotY || 0) / 8);
          u[e] || ((u[e] = 1), b.push(a));
        }
        if (a.xAxis || a.yAxis) {
          var f = a.points,
            b = [],
            g = a.graph || a.area,
            h = g && g.element,
            d = a.chart.inverted,
            k = a.xAxis,
            l = a.yAxis,
            e = d ? l.pos : k.pos;
          d = d ? k.pos : l.pos;
          k = D((a.options.label || {}).onArea, !!a.area);
          var m = l.getThreshold(a.options.threshold),
            u = {};
          if (
            a.getPointSpline &&
            h &&
            h.getPointAtLength &&
            !k &&
            f.length < (a.chart.plotSizeX || 0) / 16
          ) {
            k = g.toD && g.attr("d");
            g.toD && g.attr({ d: g.toD });
            l = h.getTotalLength();
            for (a = 0; a < l; a += 16)
              (m = h.getPointAtLength(a)),
                c({ chartX: e + m.x, chartY: d + m.y, plotX: m.x, plotY: m.y });
            k && g.attr({ d: k });
            var q = f[f.length - 1];
            c({ chartX: e + (q.plotX || 0), chartY: d + (q.plotY || 0) });
          } else
            for (l = f.length, g = void 0, a = 0; a < l; a += 1) {
              q = f[a];
              h = q.plotX;
              var t = q.plotY;
              if (G(h) && G(t)) {
                var w = { plotX: h, plotY: t, chartX: e + h, chartY: d + t };
                k && (w.chartCenterY = d + (t + D(q.yBottom, m)) / 2);
                if (g) {
                  q = Math.abs(w.chartX - g.chartX);
                  var n = Math.abs(w.chartY - g.chartY);
                  q = Math.max(q, n);
                  if (16 < q)
                    for (q = Math.ceil(q / 16), n = 1; n < q; n += 1)
                      c({
                        chartX: g.chartX + (n / q) * (w.chartX - g.chartX),
                        chartY: g.chartY + (n / q) * (w.chartY - g.chartY),
                        chartCenterY:
                          (g.chartCenterY || 0) +
                          (n / q) *
                            ((w.chartCenterY || 0) - (g.chartCenterY || 0)),
                        plotX: (g.plotX || 0) + (n / q) * (h - (g.plotX || 0)),
                        plotY: (g.plotY || 0) + (n / q) * (t - (g.plotY || 0)),
                      });
                }
                c(w);
                g = w;
              }
            }
          return b;
        }
      }
      function B(a) {
        if (this.renderer) {
          var c = this,
            f = I(c.renderer.globalAnimation).duration;
          c.labelSeries = [];
          c.labelSeriesMaxSum = 0;
          c.seriesLabelTimer && m.clearTimeout(c.seriesLabelTimer);
          c.series.forEach(function (b) {
            var g = b.options.label || {},
              h = b.labelBySeries,
              d = h && h.closest;
            g.enabled &&
              b.visible &&
              (b.graph || b.area) &&
              !b.boosted &&
              c.labelSeries &&
              (c.labelSeries.push(b),
              g.minFontSize &&
                g.maxFontSize &&
                b.yData &&
                ((b.sum = b.yData.reduce(function (a, b) {
                  return (a || 0) + (b || 0);
                }, 0)),
                (c.labelSeriesMaxSum = Math.max(
                  c.labelSeriesMaxSum || 0,
                  b.sum || 0,
                ))),
              "load" === a.type &&
                (f = Math.max(f, I(b.options.animation).duration)),
              d &&
                ("undefined" !== typeof d[0].plotX
                  ? h.animate({ x: d[0].plotX + d[1], y: d[0].plotY + d[2] })
                  : h.attr({ opacity: 0 })));
          });
          c.seriesLabelTimer = T(
            function () {
              c.series && c.labelSeries && z(c);
            },
            c.renderer.forExport || !f ? 0 : f,
          );
        }
      }
      function N(a, d, f, b, g) {
        var c = g && g.anchorX;
        g = g && g.anchorY;
        var k = f / 2;
        if (G(c) && G(g)) {
          var m = [["M", c, g]];
          var l = d - g;
          0 > l && (l = -b - l);
          l < f && (k = c < a + f / 2 ? l : f - l);
          g > d + b
            ? m.push(["L", a + k, d + b])
            : g < d
              ? m.push(["L", a + k, d])
              : c < a
                ? m.push(["L", a, d + b / 2])
                : c > a + f && m.push(["L", a + f, d + b / 2]);
        }
        return m || [];
      }
      var Q =
          (this && this.__spreadArray) ||
          function (a, d, f) {
            if (f || 2 === arguments.length)
              for (var b = 0, c = d.length, h; b < c; b++)
                (!h && b in d) ||
                  (h || (h = Array.prototype.slice.call(d, 0, b)),
                  (h[b] = d[b]));
            return a.concat(h || Array.prototype.slice.call(d));
          },
        I = a.animObject,
        R = u.format,
        J = k.setOptions,
        K = y.boxIntersectLine,
        P = y.intersectRect,
        M = m.addEvent,
        L = m.extend,
        S = m.fireEvent,
        G = m.isNumber,
        D = m.pick,
        T = m.syncTimeout,
        E = [];
      ("");
      return {
        compose: function (a, k) {
          -1 === E.indexOf(a) &&
            (E.push(a), M(d, "load", B), M(d, "redraw", B));
          -1 === E.indexOf(k) &&
            (E.push(k), (k.prototype.symbols.connector = N));
          -1 === E.indexOf(J) &&
            (E.push(J), J({ plotOptions: { series: { label: O } } }));
        },
      };
    },
  );
  u(
    a,
    "masters/modules/series-label.src.js",
    [a["Core/Globals.js"], a["Extensions/SeriesLabel/SeriesLabel.js"]],
    function (a, d) {
      d.compose(a.Chart, a.SVGRenderer);
    },
  );
});
//# sourceMappingURL=series-label.js.map
