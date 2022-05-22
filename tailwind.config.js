module.exports = {
  content: require("fast-glob").sync(["./**/*.php", "*.php"]),
  theme: {
    extend: {
      colors: {
        primary: "var(--prim)",
      },
    },
  },
  plugins: [],
};
