<h2 align="center">Ago</h2>
<p><a href="https://actions-badge.atrox.dev/SerhiiCho/ago/goto"><img src="https://img.shields.io/endpoint.svg?url=https%3A%2F%2Factions-badge.atrox.dev%2FSerhiiCho%2Fago%2Fbadge&amp;style=flat" alt="Build Status"></a>
   <a href="https://packagist.org/packages/serhii/ago"><img src="https://poser.pugx.org/serhii/ago/v/stable" alt="Latest Stable Version"></a>
   <a href="https://packagist.org/packages/serhii/ago"><img src="https://poser.pugx.org/serhii/ago/downloads" alt="Total Downloads"></a>
   <a href="https://packagist.org/packages/serhii/ago"><img src="https://poser.pugx.org/serhii/ago/license" alt="License"></a>
   <a href="https://php.net/" rel="nofollow"><img src="https://camo.githubusercontent.com/2b1ed18c21257b0a1e6b8568010e6e8f3636e6d5/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7068702d253345253344253230372e312d3838393242462e7376673f7374796c653d666c61742d737175617265" alt="Minimum PHP Version" data-canonical-src="https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg" style="max-width:100%;"></a>
</p>
<p>Date/time converter into &quot;n time ago&quot; format that supports multiple languages. You can easily contribute any language that you wish.</p>
<ul>
   <li>
      <h4 id="-contributing-https-github-com-serhiicho-ago-blob-master-contribute-md-"><a href="https://github.com/SerhiiCho/ago/blob/master/CONTRIBUTE.md">Contributing</a></h4>
   </li>
</ul>
<h2 id="languages">Languages</h2>
<p>Default language is English. Optionally you can set the language in your application by calling <code>set()</code> method and passing a flag <code>ru</code> for Russian or <code>en</code> for English language. You can see supported languages in the next section.</p>
<pre><code class="lang-php">Serhii\Ago\Lang::<span class="hljs-keyword">set</span>(<span class="hljs-string">'ru'</span>);
</code></pre>
<h4 id="supported-languages">Supported languages</h4>
<table>
   <thead>
      <tr>
         <th style="text-align:left">Language</th>
         <th style="text-align:left">Short representation</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td style="text-align:left">English</td>
         <td style="text-align:left">en</td>
      </tr>
      <tr>
         <td style="text-align:left">Russian</td>
         <td style="text-align:left">ru</td>
      </tr>
      <tr>
         <td style="text-align:left">Ukrainian</td>
         <td style="text-align:left">uk</td>
      </tr>
   </tbody>
</table>
<h2 id="usage">Usage</h2>
<p>For outputting post publishing date or something else you can just pass the date to method <code>trans()</code>. It will count the interval between now and given date and returns needed format. Internally given date will be parsed by <code>strtotime()</code> PHP&#39;s internal function.</p>
<pre><code class="lang-php"><span class="hljs-keyword">use</span> <span class="hljs-title">Serhii</span>\<span class="hljs-title">Ago</span>\<span class="hljs-title">TimeAgo</span>;

TimeAgo::trans(<span class="hljs-string">'now - 10 seconds'</span>); <span class="hljs-comment">// output: 10 seconds ago</span>
</code></pre>
<h2 id="options">Options</h2>
<p>As the seconds argument <code>trans</code> method excepts array of options or single option. Here is an example of passed options.</p>
<pre><code class="lang-php"><span class="hljs-keyword">use</span> Serhii\Ago\<span class="hljs-built_in">Option</span>;
<span class="hljs-keyword">use</span> Serhii\Ago\TimeAgo;

TimeAgo::trans(<span class="hljs-symbol">'yesterday</span>'); <span class="hljs-comment">// output: 1 day ago</span>
TimeAgo::trans(<span class="hljs-symbol">'yesterday</span>', <span class="hljs-built_in">Option</span>::NO_SUFFIX); <span class="hljs-comment">// output: 1 day</span>
TimeAgo::trans(<span class="hljs-symbol">'now</span>', <span class="hljs-built_in">Option</span>::ONLINE); <span class="hljs-comment">// output: online</span>
TimeAgo::trans(<span class="hljs-symbol">'now</span>', [<span class="hljs-built_in">Option</span>::ONLINE, <span class="hljs-built_in">Option</span>::UPPER]); <span class="hljs-comment">// output: ONLINE</span>
</code></pre>
<h4 id="available-options">Available options</h4>
<p>All options are available in <code>Serhii\Ago\Option::class</code> as constants.</p>
<table>
   <thead>
      <tr>
         <th style="text-align:left">Option</th>
         <th style="text-align:left">Description</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td style="text-align:left"><code>Option::ONLINE</code></td>
         <td style="text-align:left">Display &quot;Online&quot; if date interval within 60 seconds. After 60 seconds output will be the same as usually &quot;x time ago&quot; format.</td>
      </tr>
      <tr>
         <td style="text-align:left"><code>Option::NO_SUFFIX</code></td>
         <td style="text-align:left">Remove suffix from date and have &quot;5 minutes&quot; instead of &quot;5 minutes ago&quot;.</td>
      </tr>
      <tr>
         <td style="text-align:left"><code>Option::UPCOMING</code></td>
         <td style="text-align:left">Without this option passed time will be subtracted from current time, but with this option it will take given time and subtract current time. It is useful if you need to display a counter for some date in future.</td>
      </tr>
      <tr>
         <td style="text-align:left"><code>Option::UPPER</code></td>
         <td style="text-align:left">Set output to uppercase.</td>
      </tr>
   </tbody>
</table>

<h2 id="quick-start">Quick Start</h2>

<pre><code class="lang-bash"><span class="hljs-symbol">composer</span> <span class="hljs-meta">require</span> serhii/ago
</code></pre>

